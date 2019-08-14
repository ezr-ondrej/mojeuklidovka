<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;

class ReviewController extends BaseController {

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
        View::share('meta_title', 'Zpětná vazba k úklidu');
        View::share('meta_description', '');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');
        View::share('meta_image_height', '905');
        View::share('appVersion', Config::get('app.version'));
    }

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layout.web';

    public function index() {

        $this->layout->container = View::make('web.review_store');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function get($id) {

        $data = array();
        $data['currentRouteName'] = 'authReviews';

        $model = Reviews::find($id);

        $this->layout->container = View::make('web.auth.reviews',
            [
                'model' => $model
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function getAll() {

        $data = array();
        $data['currentRouteName'] = 'authReviews';

        $modelList = Reviews::orderBy('id', 'DESC')->paginate(10);
        $data['modelLinks'] = $modelList->links();

        $this->layout->container = View::make('web.auth.reviews',
            [
                'modelList' => $modelList
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function store() {

        $result = false;

        $model = new Reviews(array(
            'name' => Input::get('name'),
            'stars' => Input::get('stars'),
            'comment' => Input::get('comment'),
            'improvement' => Input::get('improvement'),
            'public' => Input::get('public')
        ));

        $result = $model->save();

        $array = array(
            'result' => $result
        );


        return Redirect::to('/review-success')->withMessage('Vaše zpětná vazba byla uložena. Děkujeme Vám.');

    }

    public function destroy($id) {

        $model = Reviews::find($id);
        $result = $model->delete();

        if ($result) {
            return Redirect::to('/space');
        } else {
            return Redirect::back();
        }

    }

}
