<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;

class NewsController extends BaseController {

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

	public function index($slug = NULL) {

        View::share('meta_title', 'Novinky v naší společnosti');
        View::share('meta_description', 'Co je u nás nového? Kdo využívá naše úklidové služby? Vše si můžete přečíst v našich novinkách.');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageNews';
        $newsList = NULL;
        $newsPost = NULL;

        if ($slug == NULL) {
            $newsList = News::orderBy('id', 'DESC')->paginate(5);
            $data['newsListLinks'] = $newsList->links();
        } else {
            $newsPost = News::where('slug', '=', $slug)->first();

            View::share('meta_title', $newsPost->title);
            View::share('meta_description', $newsPost->introduction);

            if ($newsPost->image) {
                View::share('meta_image', '/files/news/' . $newsPost->image . '.jpg');
            }
        }

		$this->layout->container = View::make('web.news',
            [
                'data' => $data,
                'newsList' => $newsList,
                'newsPost' => $newsPost
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
	}

    public function indexAdmin() {

        View::share('meta_title', 'Úklid Praha');
        View::share('meta_description', 'Spolehlivý úklid a kvalitní zákaznické služby jsou naší cestou k Vám. Přesvědčte se, že naše úklidové služby jsou ty, které máte rádi.');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');

        $data = array();
        $data['currentRouteName'] = 'authNews';

        $newsList = News::orderBy('id', 'DESC')->paginate(5);
        $data['newsListLinks'] = $newsList->links();

        $this->layout->container = View::make('web.auth.news',
            [
                'data' => $data,
                'newsList' => $newsList
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function create() {

        $data = array();
        $data['currentRouteName'] = '';


        $this->layout->container = View::make('web.auth.news_createUpdate');

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function get($id) {

        $data = array();
        $data['currentRouteName'] = '';

        $model = News::find($id);

        $this->layout->container = View::make('web.auth.news_createUpdate',
            [
                'model' => $model
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function update($id) {

        $data = array();
        $data['currentRouteName'] = 'authNews';

        $model = News::find($id);

        if ($model) {
            $photo_old = $model->image;
            $model->title = Input::get('title');
            $model->introduction = Input::get('introduction');
            $model->text = Input::get('text');
            $model->website = Input::get('website');
            $model->full_address = Input::get('full_address');

            $result = $model->save();

            if (Input::file('photo')) {

                $fileCounter = 1;
                $destinationPath = 'files/news/';
                $fileNewName = $model->slug;

                while (file_exists($destinationPath . $fileNewName . '.jpg')) {
                    $fileNewName = $fileNewName . '-' . ++$fileCounter;
                }

                $photo = $fileNewName . '.jpg';
                $photo_s = $fileNewName . '_s.jpg';
                $file = Input::file('photo')->move($destinationPath, $photo);

                if ($file) {
                    $img = Image::make(public_path($destinationPath . $photo));

                    if ($img->width() > 1920) {
                        $img->widen(1920);
                    }

                    $img->crop($img->width(), 550, 0, 0);

                    $img->save(public_path($destinationPath . $photo), 70);
                    $img->widen(1024);
                    $img->save(public_path($destinationPath . $photo_s));

                    $model->image = $fileNewName;
                    if($model->save()) {
                        File::delete($destinationPath . $photo_old . '.jpg');
                        File::delete($destinationPath . $photo_old . '_s.jpg');
                    }
                }

            }

        }

        $this->layout->container = View::make('web.auth.news_createUpdate',
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

        $model = new News(array(
            'title' => Input::get('title'),
            'image' => Input::get('image'),
            'introduction' => Input::get('introduction'),
            'text' => Input::get('text'),
            'website' => Input::get('website'),
            'full_address' => Input::get('full_address')
        ));

        $result = $model->save();

        if (Input::file('photo') && $result) {

            $fileCounter = 1;
            $destinationPath = 'files/news/';
            $fileNewName = $model->sluggify(true)->slug;

            while (file_exists($destinationPath . $fileNewName . '.jpg')) {
                $fileNewName = $fileNewName . '_' . ++$fileCounter;
                File::delete($destinationPath . $fileNewName . '.jpg');
                File::delete($destinationPath . $fileNewName . '_s.jpg');
            }

            $photo = $fileNewName . '.jpg';
            $photo_s = $fileNewName . '_s.jpg';
            $file = Input::file('photo')->move($destinationPath, $photo);

            if ($file) {
                $img = Image::make(public_path($destinationPath . $photo));

                if ($img->width() > 1920) {
                    $img->widen(1920);
                }

                $img->crop($img->width(), 550, 0, 0);

                $img->save(public_path($destinationPath . $photo), 70);
                $img->widen(1024);
                $img->save(public_path($destinationPath . $photo_s));

                $model->image = $fileNewName;
                $model->save();
            }

        } else {
            $model->image = null;
            $model->save();
        }

        $array = array(
            'newsPostResult' => $result
        );

        return Redirect::to('/space/news')->with($array);

    }

    public function destroy($id) {

        $model = News::find($id);
        $result = $model->delete();

        if ($result) {

            $destinationPath = 'files/news/';
            $fileName = $model->image;
            File::delete($destinationPath . $fileName . '.jpg');
            File::delete($destinationPath . $fileName . '_s.jpg');

            return Redirect::to('/space/news');
        } else {
            return Redirect::back();
        }

    }

}
