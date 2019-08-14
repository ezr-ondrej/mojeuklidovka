<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;

class BlogController extends BaseController {

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
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');
        View::share('meta_image_height', '905');
        View::share('appVersion', Config::get('app.version'));
    }

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layout.web';

	public function index($slug = NULL) {

        View::share('meta_title', 'Náš blog o úklidu');
        View::share('meta_description', 'Příběhy a články ze světa úklidu a naší úklidové firmy. Vše co nás zajímá, pomáhá nám a mohlo by zaujmout i Vás.');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageBlog';
        $blogList = NULL;
        $blogPost = NULL;

        if ($slug == NULL) {
            $blogList = Blog::orderBy('id', 'DESC')->paginate(5);
            $data['blogListLinks'] = $blogList->links();
        } else {
            $blogPost = Blog::where('slug', '=', $slug)->first();

            View::share('meta_title', $blogPost->title);
            View::share('meta_description', $blogPost->introduction);
            View::share('meta_image', '/files/blog/'.$blogPost->image.'.jpg');
        }

		$this->layout->container = View::make('web.blog',
            [
                'data' => $data,
                'blogList' => $blogList,
                'blogPost' => $blogPost
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
        $data['currentRouteName'] = 'authBlog';

        $blogList = Blog::orderBy('id', 'DESC')->paginate(5);
        $data['blogListLinks'] = $blogList->links();

        $this->layout->container = View::make('web.auth.blog',
            [
                'data' => $data,
                'blogList' => $blogList
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function create() {

        $data = array();
        $data['currentRouteName'] = '';


        $this->layout->container = View::make('web.auth.blog_createUpdate');

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function get($id) {

        $data = array();
        $data['currentRouteName'] = '';

        $model = Blog::find($id);

        $this->layout->container = View::make('web.auth.blog_createUpdate',
            [
                'model' => $model
            ]);

        $this->layout->container->header = View::make('web.auth.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function update($id) {

        $data = array();
        $data['currentRouteName'] = 'authBlog';

        $model = Blog::find($id);

        if ($model) {
            $photo_old = $model->image;
            $model->title = Input::get('title');
            $model->introduction = Input::get('introduction');
            $model->text = Input::get('text');

            $result = $model->save();

            if (Input::file('photo')) {

                $fileCounter = 1;
                $destinationPath = 'files/blog/';
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

        $this->layout->container = View::make('web.auth.blog_createUpdate',
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

        $model = new Blog(array(
            'title' => Input::get('title'),
            'image' => Input::get('image'),
            'introduction' => Input::get('introduction'),
            'text' => Input::get('text')
        ));

        $result = $model->save();

        if (Input::file('photo') && $result) {

            $fileCounter = 1;
            $destinationPath = 'files/blog/';
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
            'blogPostResult' => $result
        );

        return Redirect::to('/blog')->with($array);

    }

    public function destroy($id) {

        $model = Blog::find($id);
        $result = $model->delete();

        if ($result) {

            $destinationPath = 'files/blog/';
            $fileName = $model->image;
            File::delete($destinationPath . $fileName . '.jpg');
            File::delete($destinationPath . $fileName . '_s.jpg');

            return Redirect::to('/blog');
        } else {
            return Redirect::back();
        }

    }

}
