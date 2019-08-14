<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;

class CareerController extends BaseController {

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

        View::share('auth', Auth::check());
        View::share('device', $device);
        //View::share('meta_description', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        View::share('meta_title', 'Úklid Praha');
        View::share('meta_description', 'Spolehlivý úklid a kvalitní zákaznické služby jsou naší cestou k Vám. Přesvědčte se, že naše úklidové služby jsou ty pravé, které hledáte.');
        View::share('meta_image', '/assets/web/img/uklizeny-stul-s-kvetinami.jpg');
        View::share('meta_image_height', '905');
        View::share('appVersion', Config::get('app.version'));
    }

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layout.web';

	public function index() {

        View::share('meta_title', 'Nabídka práce úklidu v Praze');
        View::share('meta_description', 'Úspěch naší společnosti závisí především na zaměstnancích našeho úklidového personálu. Jste spolehliví a pečliví? Pak hledáme právě Vás!');
        View::share('meta_image', '/assets/web/img/pani-pracuje-pri-uklidu.jpg');

        $careerHome = Career::where('type', 'home')->orderBy('id', 'DESC')->get();
        $careerOffices = Career::where('type', 'offices')->orderBy('id', 'DESC')->get();
        $careerFlats = Career::where('type', 'flats')->orderBy('id', 'DESC')->get();

        $data = array();
        $data['currentRouteName'] = 'pageCareer';

        $this->layout->container = View::make('web.career',
            [
                'data' => $data,
                'careerHome' => $careerHome,
                'careerOffices' => $careerOffices,
                'careerFlats' => $careerFlats
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_career = View::make('web.parts.footer_career');
        $this->layout->container->footer = View::make('web.parts.footer');
	}

    public function offices() {

        View::share('meta_title', 'Nabídka práce v úklidu kanceláří - Praha');
        View::share('meta_description', 'Aktuálně rozšiřujeme náš úklidový personál v Praze. Hledáme spolehlivé a pečlivé zaměstnance, kteří by chtěli uklízet kanceláře.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari.jpg');

        $careerList = Career::where('type', 'offices')->orderBy('id', 'DESC')->get();

        $data = array();
        $data['currentRouteName'] = 'pageCareerOffice';

        $this->layout->container = View::make('web.career_offices',
            [
                'data' => $data,
                'careerList' => $careerList
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_career = View::make('web.parts.footer_career');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function home() {

        View::share('meta_title', 'Nabídka práce v úklidu domácností - Praha');
        View::share('meta_description', 'Aktuálně rozšiřujeme náš úklidový personál v Praze. Hledáme spolehlivé a pečlivé zaměstnance pro úklid domácností v bytech či rodinných domech.');
        View::share('meta_image', '/assets/web/img/uklid-domacnosti.jpg');

        $careerList = Career::where('type', 'home')->orderBy('id', 'DESC')->get();

        $data = array();
        $data['currentRouteName'] = 'pageCareerHome';

        $this->layout->container = View::make('web.career_home',
            [
                'data' => $data,
                'careerList' => $careerList
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_career = View::make('web.parts.footer_career');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function flats() {

        View::share('meta_title', 'Nabídka práce v úklidu bytových domů - Praha');
        View::share('meta_description', 'Aktuálně rozšiřujeme náš úklidový personál v Praze. Hledáme spolehlivé a pečlivé zaměstnance pro úklid vnitřních prostor bytových domů.');
        View::share('meta_image', '/assets/web/img/uklid-bytovych-domu.jpg');

        $careerList = Career::where('type', 'flats')->orderBy('id', 'DESC')->get();

        $data = array();
        $data['currentRouteName'] = 'pageCareerFlats';

        $this->layout->container = View::make('web.career_flats',
            [
                'data' => $data,
                'careerList' => $careerList
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_career = View::make('web.parts.footer_career');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function indexAdmin() {

        View::share('meta_title', 'Úklid Praha');
        View::share('meta_description', 'Spolehlivý úklid a kvalitní zákaznické služby jsou naší cestou k Vám. Přesvědčte se, že naše úklidové služby jsou ty, které máte rádi.');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');

        $data = array();
        $data['currentRouteName'] = 'authCareer';

        $careerList = Career::orderBy('id', 'DESC')->paginate(5);
        $data['careerListLinks'] = $careerList->links();

        $this->layout->container = View::make('web.auth.career',
            [
                'data' => $data,
                'careerList' => $careerList
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function create() {

        $data = array();
        $data['currentRouteName'] = '';


        $this->layout->container = View::make('web.auth.career_createUpdate');

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function get($id) {

        $data = array();
        $data['currentRouteName'] = '';

        $model = Career::find($id);

        $this->layout->container = View::make('web.auth.career_createUpdate',
            [
                'model' => $model
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function update($id) {

        $data = array();
        $data['currentRouteName'] = 'authCareer';

        $model = Career::find($id);

        if ($model) {
            $model->type = Input::get('type');
            $model->title = Input::get('title');
            $model->description = Input::get('description');
            $model->address = Input::get('address');
            $model->what = Input::get('what');
            $model->when = Input::get('when');
            $model->repetitiveness = Input::get('repetitiveness');
            $model->salary = Input::get('salary');

            $result = $model->save();

        }

        $this->layout->container = View::make('web.auth.career_createUpdate',
            [
                'model' => $model,
                'result' => $result
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function store() {

        $result = false;

        $model = new Career(array(
            'type' => Input::get('type'),
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'address' => Input::get('address'),
            'what' => Input::get('what'),
            'when' => Input::get('when'),
            'repetitiveness' => Input::get('repetitiveness'),
            'salary' => Input::get('salary'),
        ));

        $result = $model->save();

        $array = array(
            'careerPostResult' => $result
        );

        return Redirect::to('/space/career')->with($array);

    }

    public function destroy($id) {

        $model = Career::find($id);
        $result = $model->delete();

        if ($result) {
            return Redirect::to('/space/career');
        } else {
            return Redirect::back();
        }

    }

}
