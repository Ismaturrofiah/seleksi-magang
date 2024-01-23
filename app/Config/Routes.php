<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::index');
$routes->post('/login', 'Auth::login');

$routes->get('/signup', 'Auth::signup');
$routes->get('/logout', 'Auth::logout');

$routes->group(
    '',
    ['filter' => 'auth'],
    function ($routes) {
        $routes->get('/user/profile', 'Users::profile');
        $routes->get('/user/apply', 'Users::apply');
        $routes->get('/user/info', 'Users::info');
        $routes->get('/user/identity', 'StudentIdentity::index');
        $routes->post('/user/identity', 'StudentIdentity::create');
    }
);

$routes->group(
    '',
    ['filter' => 'admin'],
    function ($routes) {
        $routes->get('/dashboard/e-learning', 'Dashboard::elearning');
        $routes->get('/dashboard/work-order', 'Dashboard::workorder');

        // Prakerin
        $routes->get('/prakerin/quota', 'Prakerin::quota');

        // Intern
        $routes->get('/intern/quota', 'Intern::quota');
        $routes->get('/intern/schedule', 'Intern::schedule');
        $routes->get('/intern/position', 'Intern::position');
        $routes->get('/intern/university', 'Intern::university');
        $routes->get('/intern/selection-administrative', 'Intern::selection_administrative');
        $routes->get('/intern/selection-technical', 'Intern::selection_technical');
        $routes->get('/intern/mentor', 'Intern::mentor');
        $routes->get('/intern/student', 'Intern::student');
        $routes->get('/intern/all-student', 'Intern::allstudent');

        // Users
        $routes->get('/data-user', 'Users::index');

        // Setting
        $routes->get('/setting/display', 'Setting::index');

        // Work Order
        $routes->get('/work-order/categories', 'WorkOrder::categories');
    }
);

$routes->get('/api/position', 'API\LandingPage::index');
$routes->get('/api/detail-position/(:segment)', 'API\LandingPage::detailposition/$1');

// API Auth
$routes->post('/api/register', 'API\Users::create');
$routes->post('/api/login', 'API\Users::login');
$routes->group(
    'api',
    ['filter' => 'jwt'],
    function ($routes) {
        // API Landing Page
        $routes->get('cek-user', 'API\LandingPage::cekIdentity');
        $routes->post('apply', 'API\LandingPage::applyposition');
        $routes->get('cek-apply', 'API\LandingPage::cekapply');

        // API Check Data
        $routes->get('cek-intern', 'API\CheckData::checkintern');
        $routes->get('cek-kuota', 'API\CheckData::checkquota');

        // API Profile
        $routes->get('user', 'API\Profile::getuser');
        $routes->get('identity', 'API\Profile::getidentity');
        $routes->get('faculty', 'API\Profile::getfaculty');
        $routes->get('major', 'API\Profile::getmajor');

        // API Dashboard E-Learning
        $routes->get('quota-learning', 'API\Elearning::quota');
        $routes->get('instansi-learning', 'API\Elearning::instansi');
        $routes->get('divisi-learning', 'API\Elearning::divisi');

        // API Data User
        $routes->get('read-user', 'API\Users::session');
        $routes->get('data-users', 'API\Users::index');
        $routes->resource('user-apply', ['controller' => 'API\Apply']);

        // API Data Month
        $routes->resource('month', ['controller' => 'API\Month']);

        // API Data Region
        $routes->resource('region', ['controller' => 'API\Region']);

        // API Data Division
        $routes->resource('division', ['controller' => 'API\Division']);

        // API Data Intern
        $routes->resource('internuniversity', ['controller' => 'API\InternUniversity']);
        $routes->resource('internfaculty', ['controller' => 'API\InternUniversityFaculty']);
        $routes->resource('internmajor', ['controller' => 'API\InternUniversityMajor']);
        $routes->resource('internschedule', ['controller' => 'API\InternSchedule']);
        $routes->resource('internposition', ['controller' => 'API\InternPosition']);
        $routes->resource('internselection', ['controller' => 'API\InternSelection']);
        $routes->resource('internselectionadm', ['controller' => 'API\InternSelectionAdministrative']);
        $routes->resource('internselectionint', ['controller' => 'API\InternSelectionInterview']);
        $routes->resource('internselectionintreject', ['controller' => 'API\InternSelectionInterviewReject']);
        $routes->resource('internselectiontechnical', ['controller' => 'API\InternSelectionTechnical']);
        $routes->put('addrealization/(:segment)', 'API\InternSelectionTechnical::addRealization/$1');
        $routes->resource('internmentor', ['controller' => 'API\InternMentor']);
        $routes->resource('internstudent', ['controller' => 'API\InternStudent']);
        $routes->resource('internactivity', ['controller' => 'API\InternActivity']);

        // API Send Email
        $routes->post('reject-email-adm', 'API\SendEmail::reject_email_adm');
        $routes->post('accept-email-adm', 'API\SendEmail::accept_email_adm');
        $routes->post('reject-email-int', 'API\SendEmail::reject_email_int');
        $routes->post('accept-email-int', 'API\SendEmail::accept_email_int');

        // API Setting
        $routes->resource('settingdisplay', ['controller' => 'API\SettingDisplay']);
        $routes->post('settingdisplay/(:any)', 'API\SettingDisplay::update');

        // API Data Student 
        $routes->resource('studentidentity', ['controller' => 'API\StudentIdentity']);
        $routes->post('studentidentity/(:any)', 'API\StudentIdentity::update');

        // API Data Users
        $routes->resource('users', ['controller' => 'API\Users']);
    }
);

// Import Export Prakerin Quota


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
