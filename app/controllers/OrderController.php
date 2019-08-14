<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;

class OrderController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Landing page Controller
	|--------------------------------------------------------------------------
	*/

    public function __construct() {
        $agent = new Agent();
        $device = array();
        $device['isMobile'] = $agent->isMobile();
        $device['isTablet'] = $agent->isTablet();
        $device['isDesktop'] = $agent->isDesktop();

        View::share('device', $device);
        //View::share('meta_description', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        View::share('meta_title', 'Úklid Praha');
        View::share('meta_description', 'Spolehlivý úklid a kvalitní zákaznické služby jsou naší cestou k Vám. Přesvědčte se, že naše úklidové služby jsou ty pravé, které hledáte.');
        View::share('appVersion', Config::get('app.version'));
    }

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'layout.web';

	public function orderSubmit() {

        Validator::extend('mustBeEmpty', function($attr, $value, $params){
            if(!empty($attr)) return false;
            return true;
        });

        Validator::extend(
            'recaptcha',
            '\Rules\GoogleRecaptcha@validate'
        );



		$validator = Validator::make(Input::all(),
			array(
                'name' => array('required'),
                'phone' => array('required'),
                'description-title' => 'mustBeEmpty',
                'email' => array('required', 'email'),
                'g-recaptcha-response' => array('required', 'recaptcha')
			)
		);

		if ($validator->fails()) {
			return Redirect::back()
                ->withInput(Input::except('password'))
				->withErrors($validator);
		} else {

            $inputAll = Input::all();

            Mail::send('email.order',
                array(
                    'inputAll' => $inputAll
                ), function($message) use ($inputAll) {
                $message
                    ->to('info@mojeuklidovka.cz', 'MojeUklidovka.cz')
                    ->subject('Máte novou objednávku! Od: ' . $inputAll['email']);
            });

            //return Redirect::route('pageOrder')->with('success', true);
		}

        View::share('meta_title', 'Objednávka úklidových služeb');
        View::share('meta_description', 'Objednávka úklidové služby pro Vaši domácnost, dům nebo kancelář je u nás jednoduchá. Vychutnejte si bez námahy radost z čistého prostředí.');

        $data = array();
        $data['success'] = true;

        $this->layout->container = View::make('web.order',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
	}

}
