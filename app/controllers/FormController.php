<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;
use Rules\ReCaptcha;

class FormController extends BaseController {

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

	public function contactFormSubmit() {


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
                'description-title' => 'mustBeEmpty',
                'email' => array('required', 'email'),
                'message' => array('required'),
                'g-recaptcha-response' => array('required', 'recaptcha')
			)
		);


		if ($validator->fails()) {
			return Redirect::back()
                ->withInput(Input::except('password'))
				->withErrors($validator);
		} else {

            $inputAll = Input::all();

            Mail::send('email.contact',
                array(
                    'inputAll' => $inputAll
                ), function($message) use ($inputAll) {
                    $message
                        ->to('info@mojeuklidovka.cz', 'MojeUklidovka.cz')
                        ->subject('Dotaz z kontaktního formuláře od: ' . $inputAll['email']);
                });

		}

        $data = array();
        $data['success'] = true;

        $this->layout->container = View::make('web.contact',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
	}

}
