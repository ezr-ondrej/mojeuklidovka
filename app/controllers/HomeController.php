<?php

use Carbon\Carbon;
use Jenssegers\Agent\Agent as Agent;

class HomeController extends BaseController {

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
        View::share('meta_title', 'Úklidíme váš stres');
        View::share('meta_description', 'Spolehlivé úklidové služby pro kanceláře, domácnosti nebo bytové domy v Praze. Kvalita — 100% garance vrácení peněz — Úklidové prostředky zdarma');
        View::share('meta_image', '/assets/web/img/uklizeny-stul-s-kvetinami.jpg');
        View::share('meta_image_height', '905');
        View::share('appVersion', Config::get('app.version'));
    }

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'layout.web';

	public function index() {

        $data = array();
        $data['currentRouteName'] = 'home';

        $newsNewest = News::orderBy('id', 'DESC')->paginate(2);

		$this->layout->container = View::make('web.home',
            [
                'data' => $data,
                'newsNewest' => $newsNewest
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
	}

    /* Úklidové služby */
    public function pageServices() {

        View::share('meta_title', 'Úklidové služby Praha');
        View::share('meta_description', 'Hledáte úklidové služby v Praze? 100% garanci kvality a záruku vrácení peněz? Vyzkoušejte naše úklidové služby.');
        View::share('meta_image', '/assets/web/img/uklid-domacnosti.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageServices';

        $this->layout->container = View::make('web.services',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid domácností */
    public function pageHome() {

        View::share('meta_title', 'Úklid domácností Praha');
        View::share('meta_description', 'Hledáte úklid domácnosti v Praze? 100% garanci kvality a záruku vrácení peněz? Vyzkoušejte úklid domácností od nás.');
        View::share('meta_image', '/assets/web/img/uklid-domacnosti.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageHome';

        $this->layout->container = View::make('web.services_home',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid společných prostor */
    public function pageFloor() {

        View::share('meta_title', 'Úklid společných prostor Praha');
        View::share('meta_description', 'Hledáte úklid bytového domu v Praze? 100% garanci kvality a záruku vrácení peněz? Vyzkoušejte úklid společných prostor od nás.');
        View::share('meta_image', '/assets/web/img/uklid-bytovych-domu.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageFloor';

        $this->layout->container = View::make('web.services_floor',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Pravidelný úklid bytů Praha */
    public function pageFlat() {

        View::share('meta_title', 'Pravidelný úklid bytů Praha');
        View::share('meta_description', 'Hledáte pravidelný úklid bytu v Praze? Vyzkoušejte úklidové služby od společnosti MojeÚklidovka. 100% garance kvality a záruka vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-domacnosti.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageFlat';

        $this->layout->container = View::make('web.services_flat',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid bytů Praha */
    public function pageFlats() {

        View::share('meta_title', 'Úklid bytových domů Praha');
        View::share('meta_description', 'Hledáte úklid bytu v Praze? 100% garanci kvality a záruku vrácení peněz? Vyzkoušejte úklid bytových domů od nás.');
        View::share('meta_image', '/assets/web/img/uklid-bytovych-domu.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageFlats';

        $this->layout->container = View::make('web.services_flats',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha */
    public function pageOffice() {

        View::share('meta_title', 'Úklid kanceláří Praha');
        View::share('meta_description', 'Hledáte úklid kanceláře v Praze? 100% garanci kvality a záruku vrácení peněz? Vyzkoušejte úklid kanceláří od nás.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOffice';

        $this->layout->container = View::make('web.services_offices',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha 1 */
    public function pageOfficePrague1() {

        View::share('meta_title', 'Úklid kanceláří - Praha 1');
        View::share('meta_description', 'Hledáte úklid kanceláře v Praze 1? Vyzkoušejte úklidové služby od nás. Garantujeme 100% kvalitu a záruku vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari-praha-1.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOfficePrague1';

        $this->layout->container = View::make('web.services_officesPrague1',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha 2 */
    public function pageOfficePrague2() {

        View::share('meta_title', 'Úklid kanceláří pro Prahu 2');
        View::share('meta_description', 'Hledáte úklid kanceláře na Praze 2? Vyzkoušejte úklidové služby od nás. Garantujeme 100% kvalitu a záruku vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari-praha-1.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOfficePrague2';

        $this->layout->container = View::make('web.services_officesPrague2',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha 4 */
    public function pageOfficePrague4() {

        View::share('meta_title', 'Úklid kanceláří na Praze 4');
        View::share('meta_description', 'Hledáte úklid kanceláře pro Prahu 4? Vyzkoušejte úklidové služby od nás. Garantujeme 100% kvalitu a záruku vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari-praha-1.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOfficePrague4';

        $this->layout->container = View::make('web.services_officesPrague4',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha 6 */
    public function pageOfficePrague6() {

        View::share('meta_title', 'Úklid kanceláří - Praha 6');
        View::share('meta_description', 'Hledáte úklid kanceláře v Praze 6? Vyzkoušejte úklidové služby od nás. Garantujeme 100% kvalitu a záruku vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari-praha-1.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOfficePrague6';

        $this->layout->container = View::make('web.services_officesPrague6',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha 8 */
    public function pageOfficePrague8() {

        View::share('meta_title', 'Úklid kanceláří pro Prahu 8');
        View::share('meta_description', 'Hledáte úklid kanceláře na Praze 8? Vyzkoušejte úklidové služby od nás. Garantujeme 100% kvalitu a záruku vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari-praha-1.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOfficePrague8';

        $this->layout->container = View::make('web.services_officesPrague8',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid kanceláří Praha 12 */
    public function pageOfficePrague12() {

        View::share('meta_title', 'Úklid kanceláří - Praha 12');
        View::share('meta_description', 'Hledáte úklid kanceláře na Praze 12? Vyzkoušejte úklidové služby od nás. Garantujeme 100% kvalitu a záruku vrácení peněz.');
        View::share('meta_image', '/assets/web/img/uklid-kancelari-praha-1.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageOfficePrague12';

        $this->layout->container = View::make('web.services_officesPrague12',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Vize společnosti */
    public function pageVision() {

        View::share('meta_title', 'Vize naší úklidové firmy');
        View::share('meta_description', ' Jsme úklidová firma, kterou budete ❤. Nejdůležitější je pro nás spokojenost Vás a našich úklidových pomocníků.');
        View::share('meta_image', '/assets/web/img/kocka-v-uklizenem-byte.jpg');
        View::share('meta_image_height', '550');

        $data = array();
        $data['currentRouteName'] = 'vision';

        $this->layout->container = View::make('web.vision',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Kontakt */
    public function pageContact() {

        View::share('meta_title', 'Úklidová firma Praha');
        View::share('meta_description', 'Kontakty na naši úklidovou firmu v Praze. Napište nám nebo zavolejte. Těšíme se na spolupráci.');
        View::share('meta_image', '/assets/web/img/moje-uklidovka-kontakt.jpg');
        View::share('meta_image_height', '900');

        $data = array();
        $data['currentRouteName'] = 'contact';

        $this->layout->container = View::make('web.contact',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Objednávka služeb */
    public function pageOrder() {

        View::share('meta_title', 'Objednávka úklidu v Praze');
        View::share('meta_description', 'Jednoduchá objednávka úklidu kanceláře, domácnosti, domu nebo firmy. Dopřejte si bez námahy radost z čistého okolí.');
        View::share('meta_image', '/assets/web/img/uklid-objednavka.jpg');
        View::share('meta_image_height', '550');

        $data = array();
        $data['currentRouteName'] = 'pageOrder';

        $this->layout->container = View::make('web.order',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Úklid - otázky a odpovědi */
    public function pageQA() {

        View::share('meta_title', 'Otázky a odpovědi');
        View::share('meta_description', 'Odpovídáme na nejčastější otázky týkající se našich úklidových služeb. Přečtěte si co naše zákazníky zajímá, na co se nás ptají.');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');
        View::share('meta_image_height', '900');

        $data = array();
        $data['currentRouteName'] = 'pageQA';

        $this->layout->container = View::make('web.qa',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    /* Proč s námi? 6 důvodů! */
    public function pageWhyUs() {

        View::share('meta_title', 'Proč s námi? 6 důvodů!');
        View::share('meta_description', 'Vlastní úklidoví pomocníci — Proškolený personál — S námi s jistotou — Bezpečnost zaručena — Čistící prostředky zdarma — Budeme si Vás hýčkat');
        View::share('meta_image', '/assets/web/img/uklidove-sluzby-moje-uklidovka.jpg');

        $data = array();
        $data['currentRouteName'] = 'pageWhyUs';

        $this->layout->container = View::make('web.why_us',
            [
                'data' => $data
            ]);

        $this->layout->container->header = View::make('web.parts.header', ['data' => $data]);
        $this->layout->container->footer_services = View::make('web.parts.footer_services');
        $this->layout->container->footer = View::make('web.parts.footer');
    }

    public function pageLogin() {

        if (Auth::check()) {
            return Redirect::to('space/blog');
        }

        $data = array();
        $data['currentRouteName'] = 'login';

        $this->layout->container = View::make('web.login',
            [
                'data' => $data
            ]);

        $this->layout->container->footer = View::make('web.parts.footer');
    }

}
