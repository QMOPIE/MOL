<?php require_once('Connections/conn_db.php') ?>
<?php (!isset($_SESSION)) ? session_start() : ""; ?>
<?php require_once("php_lib.php") ?>
<!doctype html>
<html lang="zh-TW">

<head>
    <?php require_once("headfile.php"); ?>
    <script type="text/javascript" src="commlib.js"></script>
    <style type="text/css">
        .input-group1 {
            display: flex;
        }

        .input-group1>span {
            text-align: center;
            width: 10%;
            margin-top: 1%;
        }

        .input-group1>.form-control {
            width: 80%;
            background-color: rgb(254, 248, 245);
        }

        span.error-tips,
        span.error-tips::before {
            color: red;
        }

        span.valid-tips,
        span.valid-tips::before {
            font-family: "Font Awesome 5 Free";
            color: greenyellow;
            font-weight: 900;
            content: "\f00c";
        }
    </style>
    <script type="text/javascript" src="commlib.js"></script>
</head>

<body>
    <section id="header">
        <?php require_once("navbar.php"); ?>
    </section>
    <?php
    if (isset($_POST['formctl']) && $_POST['formctl'] == 'reg') {
        $email = $_POST['email'];
        $pw1 = md5($_POST['pw1']);
        $cname = $_POST['cname'];
        $tssn = $_POST['tssn'];
        $birthday = $_POST['birthday'];
        $mobile = $_POST['mobile'];
        $myzip = $_POST['myZip'] == '' ? NULL : $_POST['myZip'];
        $address = $_POST['address'] == '' ? NULL : $_POST['address'];
        $imgname = $_POST['uploadname'] == '' ? NULL : $_POST['uploadname'];
        $insertsql = "INSERT INTO member (email,pw1,cname,tssn,birthday,imgname) VALUES ('" . $email . "', '" . $pw1 . "','" . $cname . "' ,'" . $tssn . "','" . $birthday . "','" . $imgname . "')";
        $Result = $link->query($insertsql);
        $emailid = $link->lastInsertId();   //讀更新會員編號
        if ($Result) {
            //將會員的姓名、電話、地址寫入addbook
            $insertsql = "INSERT INTO addbook (emailid,setdefault,cname,mobile,myzip,address) VALUES ('" . $emailid . "', '1','" . $cname . "','" . $mobile . "' ,'" . $myzip . "','" . $address . "')";
            $Result = $link->query($insertsql);
            $_SESSION['login'] = true; //設定會員註冊完直接登入
            $_SESSION['emailid'] = $emailid;
            $_SESSION['email'] = $email;
            $_SESSION['cname'] = $cname;
            echo "<script language='javascript'>alert('謝謝您，會員資料已完成註冊');location.href='index.php';</script>";
        }
    }
    ?>
    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <br>
                            <h1>會員註冊</h1>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-2 text-left">
                            <form id="reg" name="reg" action="register.php" method="POST">
                                <div class="input-group mb-3">
                                    <label for="email">電郵：</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="*請輸入電子郵件">
                                </div>
                                <div class="input-group mb-3">
                                    <span>密碼：</span>
                                    <input type="password" name="pw1" id="pw1" class="form-control" placeholder="*請輸入密碼">
                                </div>
                                <div class="input-group mb-3">
                                    <span>生日：</span>
                                    <input type="text" name="birthday" id="birthday" class="form-control" placeholder="*請選擇生日" onfocus="(this.type='date')">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="hidden" name="captcha" id="captcha" value=''>
                                    <a href="javascript:void(0);" title="按我更新認證碼" onclick="getCaptcha();">
                                        <canvas id="can"></canvas>
                                    </a>
                                    <input type="text" name="recaptcha" id="recaptcha" class="form-control" placeholder="請輸入認證碼">
                                </div>
                                <input type="hidden" name="formctl" id="formctl" value="reg">
                                <div class="input-group mb-3">
                                    <button class="btn btn-success btn-lg" type="submit">送出</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>



    <?php require_once("jsfile.php"); ?>
    <script type="text/javascript" src="jquery.validate.js"></script>
    <script>
        $(function() {
            //自訂身分證格式驗證
            jQuery.validator.addMethod("tssn", function(value, element, param) {
                var tssn = /^[a-zA-Z]{1}[1-2]{1}[0-9]{8}$/;
                return this.optional(element) || (tssn.test(value));
            });
            //自訂手機格式驗證
            jQuery.validator.addMethod("checkphone", function(value, element, param) {
                var checkphone = /^[0]{1}[9]{1}[0-9]{8}$/;
                return this.optional(element) || (checkphone.test(value));
            });
            //自訂郵遞區號驗證
            jQuery.validator.addMethod("checkMyTown", function(value, element, param) {
                return (value !== "");
            });
        });
        //驗證form #reg表單
        $('#reg').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: 'checkemail.php'
                },
                pw1: {
                    required: true,
                    maxlength: 20,
                    minlength: 4,
                },
                pw2: {
                    required: true,
                    equalTo: '#pw1'
                },
                cname: {
                    required: true,
                },
                tssn: {
                    required: true,
                    tssn: true,
                },
                birthday: {
                    required: true,
                },
                mobile: {
                    required: true,
                    checkphone: true,
                },
                address: {
                    required: true,
                },
                myTown: {
                    checkMyTown: true,
                },
                recaptcha: {
                    required: true,
                    equalTo: '#captcha',
                },
            },
            messages: {
                email: {
                    required: 'email信箱不得為空白',
                    email: 'email信箱格式有誤',
                    remote: 'email信箱已經註冊'
                },
                pw1: {
                    required: `密碼不得為空白`,
                    maxlength: "請輸入介於4-20位英文字母與數字的組合",
                    minlength: `請輸入介於4-20位英文字母與數字的組合`,
                },
                pw2: {
                    required: '確認密碼不得為空白',
                    equalTo: '兩次輸入的密碼必須一致！'
                },
                cname: {
                    required: '使用者名稱不得為空白',
                },
                tssn: {
                    required: '身份證ID不得為空白',
                    tssn: '身份證ID格式有誤',
                },
                birthday: {
                    required: '生日不得為空白!!',
                },
                mobile: {
                    required: '手機號碼不得為空白!!',
                    checkphone: '手機號碼格式有誤',
                },
                address: {
                    required: '地址不得為空白',
                },
                myTown: {
                    checkMyTown: '需選擇郵遞區號',
                },
                recaptcha: {
                    required: '驗證碼不得為空白！',
                    equalTo: '驗證碼需相同！',
                },
            },
        });
        $(function() {
            //取的元素ID
            function getId(el) {
                return document.getElementById(el)
            }
            //圖示上傳處理
            $("#uploadForm").click(function(e) {
                var fileName = $('#fileToUpload').val();
                var idxDot = fileName.lastIndexOf(".") + 1;
                let extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
                    $('#progress-div01').css("display", "flex");
                    let file1 = getId("fileToUpload").files[0];
                    let formdata = new FormData();
                    formdata.append("file1", file1);
                    let ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "file_upload_parser.php");
                    ajax.send(formdata);
                    return false
                } else {
                    alert('目前只支援jpg,jpeg,png,gif檔案格式上傳');
                }
            });
            //上傳過程顯示百分比
            function progressHandler(event) {
                let percent = Math.round((event.loaded / event.total) * 100)
                $("#progress-bar01").css("width", percent + "%")
                $("#progress-bar01").html(percent + "%")
            }
            //上傳完成處理顯示圖片
            function completeHandler(event) {
                console.log(event);
                let data = JSON.parse(event.target.responseText)

                if (data.success == 'true') {
                    $('#uploadname').val(data.fileName)
                    $('#showimg').attr({
                        'src': 'uploads/' + data.fileName,
                        'style': 'display:block;'
                    })
                    $('button.btn.btn-danger').attr({
                        'style': 'display:none;'
                    })
                } else {
                    alert(data.error)
                }
            }
            //Upload Failed:上傳發生錯誤處理
            function errorHandler(event) {
                alert("Upload Failed:上傳發生錯誤");
            }
            //Upload Aborted:上傳作業取消處理
            function abortHandler(event) {
                alert("Upload Aborted:上傳作業取消");
            }
        });



        $(function() {
            //啟動認證碼功能
            getCaptcha();

        });

        function getCaptcha() {
            var inputTxt = document.getElementById("captcha");
            //can為canvas的ID名稱
            //150=影像寬， 50=影像高，blue=影像背景顏色
            //white=文字顏色，28px=文字大小，5=認證碼長度
            inputTxt.value = captchaCode("can", 150, 50, "blue", "white", "28px", 5);
        }

        $(function() {
            //取得縣市代碼後查鄉鎮市的名稱
            $("#myCity").change(function() {
                var CNo = $('#myCity').val();
                if (CNo == "") {
                    return false;
                }
                $.ajax({ //將鄉鎮市的名稱從後台資料庫取出
                    url: 'Town_ajax.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        CNo: CNo,
                    },
                    success: function(data) {
                        if (data.c == true) {
                            $('#myTown').html(data.m);
                            $('#myZip').val("");
                        } else {
                            alert(data.m);
                        }
                    },
                    error: function(data) {
                        alert("系統目前無法連接到後台資料庫");
                    }
                });
            });
        });
        //取得鄉鎮市代碼，查詢郵地區號放入#myZip,#zipcode
        $("#myTown").change(function() {
            var AutoNo = $('#myTown').val();
            if (AutoNo == "") {
                return false;
            }
            $.ajax({
                url: 'Zip_ajax.php',
                type: 'get',
                dataType: 'json',
                data: {
                    AutoNo: AutoNo,
                },
                success: function(data) {
                    if (data.c == true) {
                        $('#myZip').val(data.Post);
                        $('#zipcode').html(data.Post + data.Cityname + data.Name);
                        debugger;
                        console.log(data);
                    } else {
                        alert(data.m);
                    }
                },
                error: function(data) {
                    alert("系統目前無法連接到後台資料庫");
                }
            });
        });
    </script>
</body>



</html>
<?php

?>