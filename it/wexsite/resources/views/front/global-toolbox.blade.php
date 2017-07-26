<div class="container">
    @if(session('status'))
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="alert alert-success">
                    <ul>
                        <li>{{ session('status') }}</li>
                    </ul>
            </div>
        </div>
    </div>
    @endif

    @if (count($errors) > 0)
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="content_wrapper clearfix">
		<div class="sections_group">
			<div class="entry-content">
				<div class="section flv_sections_65">
					<div class="section_wrapper clearfix" style="padding:20px;">
						<div class="items_group clearfix flex-container">
							<!-- One Third (1/3) Column -->
							<div style="margin-bottom: -6px; padding-bottom: 0px;" class="column one-third column_quick_fact">
								<p class="hrmargin_0">
									&nbsp;
								</p>
							</div>
							<!-- One Third (1/3) Column -->
							<div class="column one-third column_quick_fact" style="background:rgba(0, 0, 0, 0.7);margin-top:40px; padding:20px;">
								<div class="image aligncenter" style="margin-top: 20px"><img src="/it/frontend/immagini/skills-development.png" class="scale-with-grid" alt="Step 2">
												</div>
								<p class="hrmargin_0 text-white default-font text-bold size-xbig text-center">GLOBAL TOOLBOX</p>
								<p class="hrmargin_0" style="margin-top: 25px; margin-bottom: 25px; color:#ffffff; text-align:center; font-family: 'Varela Round', sans-serif; font-size:16px; line-height:20px; font-weight:600;">
									Il tuo partner di fiducia per fare ordine tutti i dettagli pratici ed ingombranti della tua futura carriera. Una soluzione one-stop per migliorare la tua vita nella tua nuova casa.
								</p>
								<div class="aligncenter">
									<img class="scale-with-grid" style="margin:-4px 0px 15px 0; width:280px;" src="/it/frontend/immagini/coming-soon.png" alt="" />
								</div>
							</div>

							<!-- One Third (1/3) Column -->
							<div class="column one-third column_quick_fact" style="background:rgba(0, 0, 0, 0.7);margin-top:40px; padding:20px;">
								<p class="hrmargin_0 default-font text-white text-bold size-big text-center">Contattaci per un sessione gratuita di orientamento con uno dei nostri consulenti.</p>
								<form method="post" action="{{ url('services') }}" style="margin-top: 6px;">
									<!-- CASELLE DI TESTO -->
									<div class="column one-second form-row">
										<input type="text" required placeholder="Nome" name="name" value="{{ old('name') }}">
									</div>
									<div class="column one-second form-row">
										<input type="text" required placeholder="Cognome" name="surname" value="{{ old('surname') }}">
									</div>
									<div class="column one-second form-row">
										<input type="text" required placeholder="Indirizzo" name="address" value="{{ old('address') }}">
									</div>
									<div class="column one-second form-row">
										<input type="text" required placeholder="Email" name="email" value="{{ old('email') }}">
									</div>
									<div style="margin-bottom: 10px;" class="column form-row">
										<textarea name="message" placeholder="Messaggio" rows="2" cols="60">{{ old('message') }}</textarea>
									</div>
									<div class="form-group">
										<input type="radio" name="policy" required>
										<span style="color: white;">Autorizzo al trattamento dei miei dati personali ai sensi del Decreto Legislativo 196/2003. <a class="text-white" href="/it/informativa-privacy" target="_blank">Leggi la privacy policy</a></span>
									</div>

									<!-- SUBMIT -->
									<p class="no-margins text-center"><input type="submit" name="invia" value="SEND"></p>

									<input type="hidden" name="service_id" value="4" />
									{{ csrf_field() }}
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="section" style="margin-top:50px;">
					<div class="section_wrapper clearfix">
						<div class="items_group clearfix flex-container">
							<div class="column one-second box-image-container flex-col">
                                <div class="box-image box-globaltool"></div>
                                <div class="box-image-hover box-globaltool-hover"></div>
                            </div>
                            <div class="column one-second box-border-container flex-col">
                                <div class="box-border">
                                    <p class="text-gray default-font text-left">
													La vita è un viaggio meraviglioso e complicato: con tante variabili ed opzioni tra cui scegliere, a volte una spinta in più o una seconda opinione è tutto quello di cui hai bisogno per <b>fare spazio e deciderti a superare il limite verso il tuo obbiettivo più ambito</b>.
												</p>
									<p class="text-gray default-font text-left">
										Prenota una sessione con uno dei nostri Country Expert per qualsiasi dubbio ti possa venire durante la ricercar di nuovo lavoro: il nostro network globale di consulenti metterà la propria esperienza al tuo servizio.
									</p>
                                </div>
                            </div>
						</div>
					</div>
				</div>

				<div class="section" style="margin-top:10px;">
					<div class="section_wrapper clearfix">
						<div class="column one" style="margin-bottom: 10px">
							<p class="default-font size-big text-primary">Possiamo gestire insieme a te sfide come:</p>
						</div>
						<div class="items_group clearfix">
							<div class="column one-fourth">
                                <img src="/it/frontend/immagini/improving.jpg" class="img-responsive margin-auto" />
								<p class="default-font size-big text-primary" style="margin-top:5px">Migliorare la tua sicurezza con la lingua locale</p>
                            </div>
                            <div class="column one-fourth">
								<img src="/it/frontend/immagini/managing.jpg" class="img-responsive margin-auto" />
                                <p class="default-font size-big text-primary" style="margin-top:5px">Gestire il passaggio e la sistemazione in un nuovo paese e ad un nuovo lavoro</p>
                            </div>
							<div class="column one-fourth">
								<img src="/it/frontend/immagini/arrange.jpg" class="img-responsive margin-auto" />
                                <p class="default-font size-big text-primary" style="margin-top:5px">Sistemare la tua situazione con tasse e previdenza sociale</p>
                            </div>
							<div class="column one-fourth">
								<img src="/it/frontend/immagini/finding.jpg" class="img-responsive margin-auto" />
                               	<p class="default-font size-big text-primary" style="margin-top:5px">Trovare una nuova casa lontano da casa</p>
                            </div>
						</div>
					</div>
				</div>

				<div class="section" style="margin-top:10px;">
					<div class="section_wrapper clearfix">
						<div class="items_group clearfix flex-container">
							<div class="column one-second box-border-container flex-col">
                                <div class="box-border">
                                    <h3 class="text-primary default-font">COSA COMPRENDE?</h3>
                                    <hr class="primary-line" />
                                    <p class="text-gray default-font">Una sessione private con uno dei nostri esperti basata sui tuoi bisogni specifici.</p>
                                </div>
                            </div>

                            <div class="column one-second box-border-container flex-col">
                                <div class="box-border">
                                    <h3 class="text-primary default-font">COSA OTTENGO?</h3>
                                    <hr class="primary-line" />
                                    <p class="text-gray default-font">
													Una soluzione one-stop per qualsiasi imprevisto nel tuo nuovo ed eccitante percorso professionale.
												</p>
									<p class="text-gray default-font">In aggiunta, questa sessione verrà registrata: potrai riascoltarla tutte le volte che vuoi e utilizzarla come strumento di apprendimento.</p>
                                </div>
                            </div>
						</div>
					</div>
				</div>

				<div class="section flv_sections_6" style=" background: url('/it/frontend/immagini/sfondo-azzurro.jpg') no-repeat bottom center;padding-top:20px;margin-top:30px;" id="orientation-test">
					<div class="section_wrapper  mcb-section-inner">
						<div class="items_group clearfix">
							<!-- Page Title-->
							<!-- One full width row-->
							<div id="orientation" class="column one column_fancy_heading">
								<div class="fancy_heading fancy_heading_icon">
									<h2 style="color:#1f87c7; background: url('/it/frontend/immagini/linea-titolo-blu.png') no-repeat bottom center; padding-bottom: 25px;font-family: 'Varela Round', sans-serif;">PERCH&Eacute; GLOBAL TOOLBOX?</h2>
								</div>
								<div class="column_attr">
									<p style="text-align:center;font-size:22px;line-height:26px;">
										Perché così so di avere una rete di sicurezza per qualsiasi evenienza che posso attivare quando voglio, come voglio.<br/>
										Perché mi dà esperti affidabili e qualificati in grado di gestire anche le situazioni più delicate ed importanti che sto affrontando lontano da casa.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br/><br/>

						<div class="section " id="clients flv_sections_16">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One full width row-->
                                  <div class="column one column_column">
                                        <div class="column_attr ">
                                            <h4 class="flv_style_4">Al momento lavoriamo in questi paesi</h4>
                                        </div>
                                    </div>

                                    <!-- One full width row-->
                                    <div class="column one column_clients_slider" style="margin-top:-60px;">
                                        <div class="clients_slider">
                                            <div class="clients_slider_header">
                                                <a class="button button_js slider_prev" href="#"><span class="button_icon"><i class="icon-left-open-big"></i></span></a><a class="button button_js slider_next" href="#"><span class="button_icon"><i class="icon-right-open-big"></i></span></a>
                                            </div>
                                            <ul class="clients clients_slider_ul">
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Italia"><img width="145" height="75" src="/it/frontend/immagini/italia.png" class="scale-with-grid wp-post-image" alt="client_1" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Germania"><img width="145" height="75" src="/it/frontend/immagini/germania.png" class="scale-with-grid wp-post-image" alt="client_2" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Francia"><img width="145" height="75" src="/it/frontend/immagini/francia.png" class="scale-with-grid wp-post-image" alt="client_3" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="UK"><img width="145" height="75" src="/it/frontend/immagini/uk.png" class="scale-with-grid wp-post-image" alt="client_4" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Irlanda"><img width="145" height="75" src="/it/frontend/immagini/irlanda.png" class="scale-with-grid wp-post-image" alt="client_5" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Olanda"><img width="145" height="75" src="/it/frontend/immagini/olanda.png" class="scale-with-grid wp-post-image" alt="client_6" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Spagna"><img width="145" height="75" src="/it/frontend/immagini/spagna.png" class="scale-with-grid wp-post-image" alt="client_6" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Svizzera"><img width="145" height="75" src="/it/frontend/immagini/svizzera.png" class="scale-with-grid wp-post-image" alt="client_6" />
                                                        </a>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="client_wrapper">
                                                        <a title="Australia"><img width="145" height="75" src="/it/frontend/immagini/australia.png" class="scale-with-grid wp-post-image" alt="client_6" />
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                  </div>
                                </div>
                            </div>
                        </div>

				<!-- FAQ Area --></div>
		</div>
	</div>
</div>
