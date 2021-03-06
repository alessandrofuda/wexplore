<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\VicB2CMatrix;
use App\VicB2CScore;
use App\UserProfile;
use App\UserReport;
use App\Service;
use App\VicB2C;
use App\Order;
use Auth;
use PDF;
use DB;


class VicController extends Controller {

	public function __construct() {
        $this->middleware('auth');
		$this->service_id = Service::VIC;
        if(Auth::check()) {
            $this->user_chats = VicB2C::where('IdUser', Auth::user()->id)->get();
        } else {
            return redirect()->route('login')->with('error', 'You are logged out, please enter your login credentials and go next');
        }
	}

    public function index() {

        if($this->vicAlreadyCompletedCheck()) {
            return redirect()->route('vic_completed')->with('status', 'Vic already compiled');
        }

        if($this->vicInterruptedCheck()) {
             return redirect()->route('vic_start')->with('status', 'You have to complete an interrupted chat session');
        }

        $data['page_title'] = 'Career Ready';
        $data['payed'] = false;
        $data['price'] = Service::find($this->service_id)->price;
        $data['service_id'] = $this->service_id;

        if($this->paymentCheck($this->service_id)) {
            $data['payed'] = true;
        }
        
        return view('client.vic_intro', $data);
    }

    public function start() {

        if(!$this->paymentCheck($this->service_id)) {
            return back()->with('error', 'You have no order for this service!');
        }
        $data['page_title'] = 'Vic';

        // !! controllo: se l'utente ha già COMPLETATO la chat NON può rifarla. Se l'ha interrotta prima del completamento-> può riprenderla.
        if($this->vicAlreadyCompletedCheck()) {
            return redirect()->route('vic_completed')->with('status', 'Vic already compiled');
        } else {
            if($this->vicInterruptedCheck()) {
                $data['session_id'] = $this->user_chats->where('IdQuestionResponse', 'start')->sortByDesc('crdate')->first()->Value ?? null;
            } else {
                $data['session_id'] = 'VIC_B2C_'.time();
            }
        }

        return view('client.vic', $data);
    }

    public function middle() {

        if($this->vicAlreadyCompletedCheck()) {
            return redirect()->route('vic_completed')->with('status', 'Vic already compiled');
        }
        $data['vic_interrupted'] = $this->vicInterruptedCheck() ?? null;
        $data['preparation_report'] = UserReport::where('user_id', Auth::user()->id)->where('report_name', 'vic-b2c-preparation')->orderBy('created_at','DESC')->first() ?? null;
        $data['jobhunt_report'] = UserReport::where('user_id', Auth::user()->id)->where('report_name', 'vic-b2c-jobhunt')->orderBy('created_at','DESC')->first() ?? null;

        return view('client.vic_middle', $data);
    } 

    public function completed() {
        $vic_b2c_interrupted = $this->vicInterruptedCheck();
        $preparation_report = UserReport::where('user_id', Auth::user()->id)->where('report_name', 'vic-b2c-preparation')->orderBy('created_at','DESC')->first() ?? null;
        $jobhunt_report = UserReport::where('user_id', Auth::user()->id)->where('report_name', 'vic-b2c-jobhunt')->orderBy('created_at','DESC')->first() ?? null;
        
        return view('client.vic_completed', compact('vic_b2c_interrupted', 'preparation_report', 'jobhunt_report'));
    }

    public function getResponseFromVicB2CChat($vic_b2c_current_user_chat, $IdQuestionResponse) {
        return $vic_b2c_current_user_chat->where('IdQuestionResponse', $IdQuestionResponse)->first()->Value ?? null;
    }

    public function fetchPreparationReportData() {
        $user_id = Auth::user()->id;
        $vic_b2c_current_user_chat = DB::connection('ewhere')->table('wexpl_vic_b2c_reports')->where('IdUser', $user_id)->orderBy('crdate', 'DESC')->get();

        if(count($vic_b2c_current_user_chat) == 0 || !$vic_b2c_current_user_chat) {
            return null;
        }
        $target_country = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, 'country') ?? 'n.a.';

        $target_country_info = DB::connection('ewhere')->table('Matrice_VIC_B2C')->where('paese', $target_country)->orderBy('Id', 'DESC')->first() ?? null;
        $target_country_name = $target_country_info->paese ?? 'n.a.';
        $main_product_sectors = $target_country_info->Testo2_3_1_5 ?? 'n.a.';
        $your_selection_on_product_sectors = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '1_6') ?? 'n.a.'; 
        $geographic_area_where_you_move = $target_country_info->Testo2_3_1_7 ?? 'n.a.';
        $local_language_knowledge = $target_country_info->Testo2_3_1_9 ?? 'n.a.';
        $local_language_knowledge_level = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '1_10')  ?? 'n.a.'; // valori da 1 a 5 dove dove 1 è “molto basica” e 5 è “fluente”
        /*your goal*/
        $goals = [
            '1' => 'Ho terminato/sto terminando gli studi e sto cercando la mia prima esperienza professionale',
            '2' => 'Vorrei fare un’esperienza di crescita all’estero',
            '3' => 'Sono insoddisfatto del mio attuale ruolo e vorrei aprirmi a nuove esperienze professionali',
            '4' => 'Soffro per la mancanza di opportunità nel mio paese',
            '5' => 'Altro',
        ];
        $your_goal_code = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_4') ?? null;
        if($your_goal_code) {
            if($your_goal_code == '5' ) {
                $your_goal = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_4_altro') ?? 'n.a.'; 
            } else {
                $your_goal = $goals[$your_goal_code];
            }
        } else {
            $your_goal = 'n.a.';
        }
        /*your motivation*/
        $motivations = [
            '1' => 'Crescere come persona e come professionista',
            '2' => 'Migliorare la qualità della vita per me e/o per la mia famiglia',
            '3' => 'Migliorare la mia situazione economica',
            '4' => 'Raggiungere un partner/familiare',
            '5' => 'Rientrare nel mio Paese dopo diversi anni all’estero senza fare passi indietro',
            '6' => 'Altro',
        ];
        $your_motivation_code = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_6') ?? null;
        if($your_motivation_code) {
            if($your_motivation_code == '6' ) {
                $your_motivation = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_6_altro') ?? 'n.a.';
            } else {
                $your_motivation = $motivations[$your_motivation_code];
            }
        } else {
            $your_motivation = 'n.a.';
        }
        /*your target role*/
        $target_role = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_8') ?? 'n.a.';
        /*sectors you can aim at*/
        $target_sector = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_10') ?? 'n.a.';
        /*In [paese] è [facile/difficile] spostarsi da un settore all'altro*/
        $modality = $target_country_info->modalita ?? null;
        /*cultural fit*/
        $cultural_fit = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_13') ?? 'n.a.';
        /*gap/ostacoli*/
        $gaps = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '2_15') ?? 'n.a.';
        /*cv check*/
        $cv_check = [
            'europass' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_2') ?? null,
            'language' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_4') ?? null,
            'lenght' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_6') ?? null,
            'profile' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_8') ?? null,
            'contacts' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_10') ?? null,
            'informations' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_12') ?? null,
            'linkedin' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '3_14') ?? null,
        ];
        $cv_check_score = null;
        if(!in_array(null, $cv_check)) {
            $cv_check_sum = array_sum($cv_check);
            $cv_check_score = $cv_check_sum.' su '. count($cv_check);
        } 
        /*cover letter*/
        $cover_letter = [
            'lenght' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '4_6') ?? null,
            'language' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '4_8') ?? null,
            'motivation' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '4_10') ?? null,
            'adjectives' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '4_12') ?? null,
            'advantages' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '4_17') ?? null,
        ];
        $cover_letter_score = null;
        if(!in_array(null, $cover_letter)){
            $cover_letter_sum = array_sum($cover_letter);
            $cover_letter_score = $cover_letter_sum.' su '. count($cover_letter);
        }

        return compact('target_country_name', 'main_product_sectors', 'your_selection_on_product_sectors', 'geographic_area_where_you_move', 'local_language_knowledge', 'local_language_knowledge_level', 'your_goal', 'your_motivation', 'target_role', 'target_sector', 'modality', 'cultural_fit', 'gaps', 'cv_check', 'cv_check_score', 'cover_letter', 'cover_letter_score');
    }


    public function generatePreparationReport() {

        ini_set('max_execution_time', 180); //3 minutes
        
        
        $data = $this->fetchPreparationReportData();
        

        if(!$data) {
            return  back()->with('error', 'You haven\'t compiled Vic yet');
        }

        $data['full_name'] = Auth::user()->name.' '.Auth::user()->surname;
        $data['name'] = Auth::user()->name;
        $data['origin_country'] = UserProfile::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first()->country ?? 'n.a.';
        $data['title'] = 'WELCOME IN WEXPLORE<br/>SBLOCCA IL POTENZIALE DELLA TUA CARRIERA';
        $data['meta_title'] = 'Vic Preparation Report';

        $pdf = PDF::loadView('reports.vic-b2c-preparation', $data);
        // return view('reports.vic-b2c-preparation', $data);
        // return $pdf->stream(); // load pdf in browser

        return $pdf->download('vic-b2c-preparation-report-'.Str::slug($data['full_name'], '-').'-'.date('Y-m-d').'-'.time().'.pdf');

    }










    public function generatePreparationReportAjax() {
        ini_set('max_execution_time', 180);  //3 minutes
        $data = $this->fetchPreparationReportData();
        if(!$data) {
            return response()->json(['status' => 403, 'message' => 'You haven\'t compiled Vic yet']);
        }
        $data['full_name'] = Auth::user()->name.' '.Auth::user()->surname;
        $data['name'] = Auth::user()->name;
        $data['origin_country'] = UserProfile::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first()->country ?? 'n.a.';
        $data['title'] = 'WELCOME IN WEXPLORE<br/>SBLOCCA IL POTENZIALE DELLA TUA CARRIERA';
        $data['meta_title'] = 'Vic Preparation Report';

        // lato client: a inizio chiamata parte loading animation
        // lato server (questo controller): genero pdf, salvo in Storage e ritorno json con status ok, nome del file storato o direttamente il link per scaricarlo
        // lato client: on success --> se ok 200, 
            // 1) prendo il link e genero in runtime l'html per scaricare il file
            // 2) triggero il click sul link
            // 3) nascondo il loading animation

        $pdf = PDF::loadView('reports.vic-b2c-preparation', $data);

        
        // store in filesystem
        $storage_path = 'reports/user/'.Auth::user()->id.'/';
        $filename = 'vic-b2c-preparation-report-'.Str::slug(Str::limit($data['full_name'], 25), '-').'-'.date('Y-m-d').'-'.time().'.pdf'; 
        Storage::put($storage_path.$filename, $pdf->output());

        //store in DB
        UserReport::create(['user_id' => Auth::user()->id, 'report_name' => 'vic-b2c-preparation', 'report_url' => $storage_path.$filename]);
        // gestire conflitti nel caso in cui l'utente abbia già un suo report

        return response()->json(['status' => 200, 'message' => 'Report correctly generated', 'storage_path' => storage_path($storage_path), 'filename' => $filename]);
    }
    
    public function generateJobhuntReportAjax() {
        ini_set('max_execution_time', 180);  //3 minutes
        $data = $this->fetchJobHuntReportData();
        if(!$data) {
            return response()->json(['status' => 403, 'message' => 'You haven\'t compiled Vic yet']);
        }

        $data['full_name'] = Auth::user()->name.' '.Auth::user()->surname;
        $data['name'] = Auth::user()->name;
        $data['origin_country'] = UserProfile::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first()->country ?? 'n.a.';
        $data['title'] = 'WELCOME IN WEXPLORE<br/>SBLOCCA IL POTENZIALE DELLA TUA CARRIERA';
        $data['meta_title'] = 'Vic Job Hunt Report';

        $pdf = PDF::loadView('reports.vic-b2c-job-hunt', $data);
        
        // store in filesystem
        $storage_path = 'reports/user/'.Auth::user()->id.'/';
        $filename = 'vic-b2c-job-hunt-report-'.Str::slug(Str::limit($data['full_name'], 25), '-').'-'.date('Y-m-d').'-'.time().'.pdf'; 
        Storage::put($storage_path.$filename, $pdf->output());

        //store in DB
        UserReport::create(['user_id' => Auth::user()->id, 'report_name' => 'vic-b2c-jobhunt', 'report_url' => $storage_path.$filename]);

        return response()->json(['status' => 200, 'message' => 'Report correctly generated', 'storage_path' => storage_path($storage_path), 'filename' => $filename]);
    }

    public function userReportDownload($report_name) {

        switch ($report_name) {
            case 'preparation-report':
                $report_name = 'vic-b2c-preparation';
                break;
            case 'jobhunt-report':
                $report_name = 'vic-b2c-jobhunt';
                break;
            default:
                $report_name = null;
                break;
        }

        $report = UserReport::where('user_id', Auth::user()->id)->where('report_name', $report_name)->orderBy('created_at', 'DESC')->first() ?? null;
        if($report && file_exists(storage_path('app/'.$report->report_url))) {

            // if(!$this->paymentCheck($this->service_id)) {
            //     return abort(403, 'You have no order for this service!');
            // }

            return Storage::download($report->report_url);
        }

        return abort(404, 'Report Not Found');
    }













    public function fetchJobHuntReportData() {

        $user_id = Auth::user()->id;
        $vic_b2c_current_user_chat = DB::connection('ewhere')->table('wexpl_vic_b2c_reports')->where('IdUser', $user_id)->orderBy('crdate', 'DESC')->get();

        if(count($vic_b2c_current_user_chat) == 0 || !$vic_b2c_current_user_chat) {
            return null;
        }

        $target_country = $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, 'country') ?? 'n.a.';
        $target_country_info = DB::connection('ewhere')->table('Matrice_VIC_B2C')->where('paese', $target_country)->orderBy('Id', 'DESC')->first() ?? null;
        $target_country_name = $target_country_info->paese ?? 'n.a.';
        
        $useful_sites_head_hunter = $target_country_info->Testo2_3_6_29 ?? 'n.a.';
        $are_first_channel = $target_country_info->Testo2_3_6_16 ?? 'n.a.';
        $are_specialized = $target_country_info->Testo2_3_6_22 ?? '';
        $useful_sites_job_board = $target_country_info->Testo2_3_7_20 ?? 'n.a.';
        $useful_sites_networking = $target_country_info->Testo2_3_8_15 ?? 'n.a.';

        $score = 'n.a.';
        $scores = DB::connection('ewhere')->table('vVic_b2c_punti_6_7_8')->where('IdUser', $user_id)->get(); // !! query sulla view mysql -> collo di bottiglia !!
        $head_hunter_score = $scores->where('report6_iscompleted', 1)->first()->report6_sum ?? null; // nel DB e-where: è la view vVic_b2c_punti_6_7_8 colonne: report6 
        $job_board_score = $scores->where('report7_iscompleted', 1)->first()->report7_sum ?? null; // nel DB e-where: è la view vVic_b2c_punti_6_7_8 colonna: report7
        $network_score = $scores->where('report8_iscompleted', 1)->first()->report8_sum ?? null; // nel DB e-where: è la view vVic_b2c_punti_6_7_8 colonna: report8
        if($head_hunter_score && $job_board_score && $network_score) {
            $points = $head_hunter_score + $job_board_score + $network_score;
            $total_base_score = count($scores);
            $score = $points.' su '.$total_base_score;
        } 
        $star = [
            's' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '9_4') ?? 'n.a.',
            't' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '9_6') ?? 'n.a.',
            'a' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '9_8') ?? 'n.a.',
            'r' => $this->getResponseFromVicB2CChat($vic_b2c_current_user_chat, '9_10') ?? 'n.a.',
        ];
        $final_recommendations = $target_country_info->Testo2_3_9_11 ?? 'n.a.'; 
        $goodluck = $target_country_info->Testo2_3_11_6 ?? '';

        return compact('target_country_name', 'useful_sites_head_hunter', 'are_first_channel', 'are_specialized', 'useful_sites_job_board', 'useful_sites_networking', 'score', 'star', 'final_recommendations', 'goodluck');

    }

    public function generateJobHuntReport() {

        ini_set('max_execution_time', 180); //3 minutes

        $data = $this->fetchJobHuntReportData();
        
        if(!$data) {
            return  back()->with('error', 'You haven\'t compiled Vic yet');
        }

        $data['full_name'] = Auth::user()->name.' '.Auth::user()->surname;
        $data['name'] = Auth::user()->name;
        $data['origin_country'] = UserProfile::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first()->country ?? 'n.a.';
        $data['title'] = 'WELCOME IN WEXPLORE<br/>SBLOCCA IL POTENZIALE DELLA TUA CARRIERA';
        $data['meta_title'] = 'Vic Job Hunt Report';

        $pdf = PDF::loadView('reports.vic-b2c-job-hunt', $data);
        // return view('reports.vic-b2c-job-hunt', $data);
        // return $pdf->stream(); // load pdf in browser

        return $pdf->download('vic-b2c-job-hunt-report-'.Str::slug($data['full_name'], '-').'-'.date('Y-m-d').'-'.time().'.pdf');
    }


    public function generateTakeOffReport() {
        return 'work in progress';
    }


    public function reportDocumentDownload($document_name) {
        if(file_exists(storage_path('app/documents/reports/vic/'.$document_name.'.docx'))) {

            if(!$this->paymentCheck($this->service_id)) {
                return abort(403, 'You have no order for this service!');
            }

            return Storage::download('documents/reports/vic/'.$document_name.'.docx');
        }

        return abort(404, 'Document Not Found');
    }






}
