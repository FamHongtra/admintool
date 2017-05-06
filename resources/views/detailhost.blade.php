<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Arsenal" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Abel|Arsenal" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">

  <!-- Compiled and minified JavaScript -->

  <!-- icon -->
  <link rel="stylesheet" href="https://cdn.iconmonstr.com/1.2.0/css/iconmonstr-iconic-font.min.css">
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style media="screen">
  html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Abel', sans-serif;
    font-weight: 100;
    height: 100vh;
    margin: 0;
    /*
    display: flex;
    min-height: 100vh;
    flex-direction: column;*/
  }
  /*
  main {
  flex: 1 0 auto;
  }*/

  .input-field1.input-field input[type=text]:focus + label {
    color: #00acc1;
  }
  .input-field1.input-field input[type=text]:focus {
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }

  .input-field1.input-field input[type=text].valid {
    border-bottom: 1px solid #0097a7;
    box-shadow: 0 1px 0 0 #0097a7;
  }

  .input-field1.input-field .prefix.active {
    color: #00acc1;
  }
  .input-field1.input-field input[type=number]:focus + label {
    color: #00acc1;
  }
  .input-field1.input-field input[type=number]:focus {
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }
  .input-field1.input-field input[type=number].valid {
    border-bottom: 1px solid #0097a7;
    box-shadow: 0 1px 0 0 #0097a7;
  }

  .input-field2.input-field input[type=text]:focus + label {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=text]:focus {
    border-bottom: 1px solid #00bfa5;
    box-shadow: 0 1px 0 0 #00bfa5;
  }

  .input-field2.input-field .prefix.active {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=number]:focus + label {
    color: #00bfa5;
  }
  .input-field2.input-field input[type=number]:focus {
    border-bottom: 1px solid #00bfa5;
    box-shadow: 0 1px 0 0 #00bfa5;
  }
  hr.style-four {
    height: 12px;
    border: 0;
    box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5);
  }
  .file-path-wrapper input[type=text].valid{
    border-bottom: 1px solid #00acc1;
    box-shadow: 0 1px 0 0 #00acc1;
  }
  .modal { width: 40% !important ; max-height: 50% !important ; overflow-y: hidden !important ;}

  </style>
</head>

<body onload="checkStatus()">

  <nav>
    <div class="nav-wrapper teal lighten-1">
      <a href="#" class="brand-logo">Logo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="sass.html">Sass</a></li>
        <li><a href="badges.html">Components</a></li>
        <li><a href="collapsible.html">JavaScript</a></li>
      </ul>
    </div>
  </nav>
  <br><br>
  <div id="openmodal" style="display:none">
    @if($errors->any())
    {{$errors->first()}}
    @endif
  </div>
  <div class="row">
    <div class="col s12" align="center"></div>
    <div class="col s3" align="center">
      <div class="card cyan darken-3" style="width:250px">
        <h5 style="padding:10px;color:white">{{$obj->servername}}<a href=""><i class="material-icons right" style="color:white">settings</i></a></h5>
      </div>
      <div class="card" style="width:250px;">
        <div class="card-image" style="padding:20px">
          <img src="../img/server.png">
          <span class="card-title" style="color:#263238"><b>{{$obj->host}}</b></span>
        </div>
        <div class="card-action white">
          <a class="modal-trigger waves-effect waves-light btn-large cyan darken-3" onclick="window.location.reload()"><i class="material-icons right">swap_vert</i>Connection</a>
        </div>
      </div>
    </div>
    <div class="col s5">
      <div class="row">
        <div class="col s12">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <span class="card-title"><h4>
                <?php SSH::into('ansible')->run(array(
                  "ansible -m shell -a 'cat /etc/*-release' $obj->servername --become",
                ), function($line){
                  if (strpos($line, 'SUCCESS') !== false) {
                    $bfname_pos = strpos($line,"PRETTY_NAME=")+13;
                    $bfname = substr($line,$bfname_pos);
                    $afname_pos = strpos($bfname,"\"");
                    $osversion = substr($bfname,0,$afname_pos);
                    echo $osversion;
                  }else{
                    echo "Undifined" ;
                  }
                }); ?></h4></span>
              </div>
              <div class="card-action blue-grey lighten-5">
                <i class="im im-linux-os" style="color:#546e7a;"><span style="font-family: 'Abel', sans-serif;margin-left:20px; color:#546e7a">Linux OS Version</span></i>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col s12 m6">
            <div class="card blue-grey darken-1">
              <div class="card-content white-text">
                <span class="card-title">Processor</span>
                <?php SSH::into('ansible')->run(array(
                  "ansible -m shell -a 'cat /proc/cpuinfo | grep \"model name\" | uniq' $obj->servername --become",
                ), function($line){
                  if (strpos($line, 'SUCCESS') !== false) {
                    $bfcpu_pos = strpos($line,":")+1;
                    $bfcpu = substr($line,$bfcpu_pos);
                    $atcpu_pos = strpos($bfcpu,"@");
                    $atcpu = substr($bfcpu,0,$atcpu_pos-1);

                    $cpuspeed = substr($bfcpu,$atcpu_pos+1);
                    echo $atcpu;
                    echo "<div align=\"right\" style=\"margin-right:30px\"><h4>$cpuspeed</h4></div>";
                  }else{
                    echo "<br>";
                    echo "<div align=\"right\" style=\"margin-right:30px\"><h4>Undifined</h4></div>" ;
                  }
                }); ?>
              </div>
            </div>
          </div>
          <div class="col s12 m6">
            <div class="card blue-grey darken-1">
              <div class="card-content white-text">
                <span class="card-title" >Installed memory (RAM)</span>
                <div class="" align="right" style="margin-right:30px">
                  <br>
                  <?php
                  $GLOBALS['total'] = 0;
                  SSH::into('ansible')->run(array(
                    "ansible -m shell -a 'dmidecode -t 17 | grep Size' $obj->servername --become",
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
                      echo "<h4>";
                      echo round($GLOBALS['total']/1024)." Gb";
                      echo "</h4>";
                    }else{
                      echo "<h4>Undifined</h4>";
                    }
                  }); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col s2">
        <div class="row">
          <div class="col s12">
            <div class="card-panel teal">
              <span class="white-text">I am a very simple card. I am good at containing small bits of information.
                I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.

              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="row">
        <div class="col s8">
          <div class="card blue-grey darken-1">
            <div class="card-content white-text">
              <div class="row">
                <div class="col s9">
                  <span class="card-title">Repository of Configuration</span>
                </div>
                <div class="col s3" align="right">
                  <a class="modal-trigger waves-effect waves-light btn-large teal" href="#modal1"><i class="material-icons right">library_add</i>Add Config</a>
                </div>
              </div>
            </div>
            <?php
            use Illuminate\Support\Facades\DB as DB;
            $configs = DB::table('configs')->where('host_id', $obj->id )->get();
            ?>
            <div class="card-action blue-grey lighten-5 blue-grey darken-text" >
              <table>
                <thead>
                  <tr>
                    <th style="width:4%">No.</th>
                    <th style="width:31%">Configuration Name</th>
                    <th style="width:35%">Path</th>
                    <th style="width:30%">Action</th>
                  </tr>
                </thead>
                @foreach($configs as $indexKey=>$config)
                <tbody align="right">
                  <tr>
                    <td>{{$indexKey+1}}</td>
                    <td>{{$config->configname}}</td>
                    <td>{{$config->configpath}}</td>
                    <td><a class="waves-effect waves-light btn">View</a> <a class="waves-effect waves-light btn">Edit</a> <a class="waves-effect waves-light btn">Delete</a></td>
                  </tr>
                </tbody>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="server" class="" style="display:none">
      {{$obj->id}}
    </div>
    <div class="container" align="left">
      <!-- Page Content goes here -->


      <!-- Modal Structure -->
      <div id="modal1" class="modal modal-fixed-footer">
        <div class="modal-content">
          <br>
          <!-- <h5>Add Host</h5> -->
          <!-- <p>You should add host by using rsa key for secure</p> -->
          <!-- <hr class="style-four"><br> -->
          <div class="row">
            <div class="col s1"></div>
            <div class="col s10">
              <br>
              <div id="byrsakey" class="row" style="display:block;">
                <form action="{{url('checkpath')}}" id="hostform" class="col s12" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="serverid" value="" id="serverid">
                  <div class="row">
                    <div class="input-field col s2"></div>
                    <div class="input-field  col s8">
                      <i class="material-icons prefix">description</i>
                      <input id="icon_prefix" type="text" class="validate" name="pathname" required>
                      <label for="icon_prefix">Name</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s2"></div>
                    <div class="input-field col s8">
                      <i class="material-icons prefix">label</i>
                      <input id="icon_prefix" type="text" class="validate" name="pathconf" required>
                      <label for="icon_prefix">Path</label>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col s4"></div>
                    <div class="file-field col s4">
                      <button class="modal-trigger waves-effect waves-light btn-large teal" type="submit" name="button"><i class="material-icons  right">done</i>Save Path</button>
                    </div>
                    <div class="col s4"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div id="status"  style="display:none">
        <?php
        use Collective\Remote\RemoteFacade as SSH ;
        SSH::into('ansible')->run(array(
          "ansible -m ping $obj->servername",
        ), function($line){
          // if (strpos($line, 'pong') !== false) {
          //   echo "<span>connected</span>" ;
          // }
          echo $line;
        });
        ?>
      </div>
    </div>
    <script src="js/progressbar.js"></script>

    <!--Import jQuery before materialize.js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
    <script type="text/javascript">
    //dialogs


    function checkStatus(){

      $addpathcomeback = document.getElementById('openmodal').textContent ;
      if(($addpathcomeback.indexOf("0") >= 0)||($addpathcomeback.indexOf("1") >= 0)){
        if(($addpathcomeback.indexOf("1") >= 0)){
          $msg = "<span>The configuration file was saved to the system.</span>"
          Materialize.toast($msg, 5000,'teal accent-3 rounded');
        }else if(($addpathcomeback.indexOf("0") >= 0)){
          $msg = "<span>Sorry, the configuration file not found.</span>"
          Materialize.toast($msg, 5000,'pink accent-1 rounded');
        }
      }else{
        $status= document.getElementById('status').textContent;
        if(($status.indexOf("SUCCESS") >= 0)){
          $msg = "<span>connected</span>"
          Materialize.toast($msg, 5000,'teal accent-3 rounded');
        }else{
          $msg= "<span>disconnect</span>";
          Materialize.toast($msg, 5000,'pink accent-1 rounded');
        }
      }


      // if($addpathcomeback=="0" || $addpathcomeback=="1"){
      // alert($addpathcomeback);
      //
      // }
      $server = document.getElementById('server').textContent ;
      document.getElementById('serverid').value = $server;
    }
    //modal scripts
    $(document).ready(function(){
      // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
      $('.modal').modal();
    });

    function byPassword() {
      document.getElementById('byrsakey').style.display = "none";
      document.getElementById('bypassword').style.display = "block";
      $("#password").removeClass('teal accent-4');
      $("#password").addClass('teal darken-3');
      $("#rsakey").removeClass('cyan darken-3');
      $("#rsakey").addClass('cyan darken-1');
    }
    function byRSAKey() {
      document.getElementById('bypassword').style.display = "none";
      document.getElementById('byrsakey').style.display = "block";
      $("#password").removeClass('teal darken-3');
      $("#password").addClass('teal accent-4');
      $("#rsakey").removeClass('cyan darken-1');
      $("#rsakey").addClass('cyan darken-3');
    }


    $("#submitbtn").on('click', function(){
      $form1 = document.getElementById('byrsakey').style.display ;

      $form2 = document.getElementById('bypassword').style.display ;
      if($form1 == "block"){
        alert('Sent form RSA');
        $("#hostform").submit();
      }else if($form2 == "block"){
        alert('Sent form Pass');
        $("#hostform2").submit();
      }
    });

    </script>
  </body>

  </html>
