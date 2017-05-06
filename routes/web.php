<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/showhost', function () {

  $objs = App\Host::where('user_id',1)->get();

  $data['objs'] = $objs;
  // foreach ($objs as $obj) {
  //   echo $obj->servername;
  // }

  //
  return view('showhost',$data);
});
Route::post('/loading', 'HostController@loading');
Route::post('/addhost', 'HostController@store');
// Route::post('/addhost', 'HostController@store');
Route::get('/detailhost/{hostid}', 'HostController@show');
Route::get('/hostall/{id}', 'HostController@showhost');
Route::post('/checkpath', 'ConfigController@check');

Route::get('/testssh', function () {
  return SSH::into('gitlab2')->run(array(
    'echo "Hello3" | sudo tee --a /file',
  ), function($line){
    echo $line;
  });
});

Route::get('/testload', function () {
  return view('loadingpage');
});

Route::get('/testping', function () {
  $GLOBALS['total'] = 0;
  SSH::into('ansible')->run(array(
    "ansible -m shell -a 'dmidecode -t 17 | grep Size' client --become",
  ), function($line){
    if (strpos($line, 'SUCCESS') !== false) {
      $bfsize_pos = strpos($line,"Size:");
      $bfmem = substr($line,$bfsize_pos);
      $atmem_pos = strpos($bfmem,"Size: No Module Installed");
      $atmem_all = substr($bfmem,0,$atmem_pos-1);//get Size: xxxx MB ALL
      while(substr_count($atmem_all, 'Size:')!=false){
        $bfint = strpos($atmem_all,'Size:');
        $integ = substr($atmem_all,$bfint+6);
        $atint = strpos($integ,'MB');
        $integ = substr($integ,0,$atint-1);
        $GLOBALS['total']+=$integ;
        $bf = strpos($atmem_all,"MB");
        $atmem_all = substr($atmem_all,$bf+3);
      }
    }});
    $togb = round($GLOBALS['total']/1024)." Gb";
    return $togb;
  });




  Route::get('/remoteansible', function () {
    return SSH::into('ansible')->run(array(
      // 'echo "[laravel2]" | sudo tee --a /etc/ansible/hosts',
      // 'echo "13.228.11.182 ansible_ssh_user=ubuntu ansible_ssh_private_key_file=/etc/ansible/keyfiles/clienttest.pem" | sudo tee --a /etc/ansible/hosts',
      // 'ansible -m ping laravel',
      // 'ansible -m shell -a "mkdir /laravelcome2!" laravel --become'
      'ansible -m shell -a "cat /etc/*-release" TestClient --become',
    ), function($line){
      $bfname_pos = strpos($line,"PRETTY_NAME=")+13;
      $bfname = substr($line,$bfname_pos);
      $afname_pos = strpos($bfname,"\"");
      echo substr($bfname,0,$afname_pos);
    });
  });






  // Route::get('/testdb', function () {
  //
  //   SSH::into('ansible')->run(array(
  //     "ansible -m ping myserver",
  //   ), function($line){
  //
  //     if(strpos( $line, 'SUCCESS' ) !== false ){
  //
  //       SSH::into('ansible')->run(array(
  //         "ansible -m shell -a 'dmidecode -t 16' myserver --become",
  //       ), function($line){
  //
  //         $bfmem_pos = strpos($line,"Maximum Capacity:")+18;
  //         $bfmem = substr($line,$bfmem_pos);
  //         $atmem_pos = strpos($bfmem,"Error Information Handle:");
  //         $atmem = substr($bfmem,0,$atmem_pos-1);
  //         // $n = DB::select('select * from testdb where testid = ?',[1]);
  //         DB::insert('insert into testdb (test) values (?)', [$atmem]);
  //
  //       });
  //
  //       SSH::into('ansible')->run(array(
  //         "ansible -m shell -a 'cat /proc/cpuinfo | grep \"model name\" | uniq' myserver --become",
  //       ), function($line){
  //
  //         $bfcpu_pos = strpos($line,":")+1;
  //         $bfcpu = substr($line,$bfcpu_pos);
  //         $atcpu_pos = strpos($bfcpu,"@");
  //         $atcpu = substr($bfcpu,0,$atcpu_pos-1);
  //
  //         $cpuspeed = substr($bfcpu,$atcpu_pos+1);
  //         echo $atcpu;
  //         echo $cpuspeed;
  //
  //         // DB::insert('insert into hostdetail (memcapacity) values (?)', [$atmem]);
  //         DB::insert('insert into testdb (test) values (?)', [$atcpu]);
  //         DB::insert('insert into testdb (test) values (?)', [$cpuspeed]);
  //
  //       });
  //
  //
  //     }
  //   });
  // });
