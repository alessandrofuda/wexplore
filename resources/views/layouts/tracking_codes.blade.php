<!--Google Analytics-->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google_analytics.id') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ config('services.google_analytics.id') }}');
</script>

<!-- Facebook Pixel Code -->
<script>
	!function(f,b,e,v,n,t,s){
		if(f.fbq)return;
		n=f.fbq=function(){
			n.callMethod ? n.callMethod.apply(n,arguments) : n.queue.push(arguments)
		};
		if(!f._fbq)f._fbq=n;
		n.push=n;
		n.loaded=!0;
		n.version='2.0';
		n.queue=[];
		t=b.createElement(e);
		t.async=!0;
		t.src=v;
		s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)
	}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');

	fbq('init', '{{ config('services.facebook.id') }}'); 
	fbq('track', 'PageView');
</script>
<noscript>
	<img height="1" width="1" src="https://www.facebook.com/tr?id={{ config('services.facebook.id')}}&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->