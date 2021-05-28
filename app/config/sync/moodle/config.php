<?php  // Moodle configuration file

require_once('../../autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable('/');
$dotenv->load();

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = (isset($_ENV['DB_HOST'])) ? $_ENV['DB_HOST'] : 'moodle-mysql';
$CFG->dbname    = (isset($_ENV['DB_NAME'])) ? $_ENV['DB_NAME'] : 'moodle';
$CFG->dbuser    = (isset($_ENV['DB_USER'])) ? $_ENV['DB_USER'] : 'moodle';
$CFG->dbpass    = (isset($_ENV['DB_PASSWORD'])) ? $_ENV['DB_PASSWORD'] : '';
$CFG->prefix    = '';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => (isset($_ENV['DB_PORT'])) ? intval($_ENV['DB_PORT']) : 3306,
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = (isset($_ENV['SITE_URL'])) ? $_ENV['SITE_URL'] : 'http://localhost:8080';
$CFG->dataroot  = (isset($_ENV['MOODLE_DATA_MOUNT_PATH'])) ? $_ENV['MOODLE_DATA_MOUNT_PATH'] : '/vendor/moodle/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

$CFG->sslproxy = true; // Only use proxy in OCP

echo '<p>Config loaded:</p><pre>',print_r($CFG),'</pre>';

$CFG->getremoteaddrconf = 0;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
