<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>SE</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />


    <!-- favicon Error -->
    <link rel="shortcut icon" href="#" />

    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <!--jquery cookie-->
    <script src="js/jquery.cookie.js"></script>

    <link href="css/import.css" rel="stylesheet" />
    <script>
    

    </script>
</head>
<body>
        <h1>KimSungEun<span>Portfolio</span><span></span><span></span></h1>
        
  
        <!--관리자 페이지-->
        <div class="addArea_bg">
             <section class="addArea mCustomScrollbar" >
                 <form method="post" action="common/insert.php"  enctype="multipart/form-data">
                     <fieldset>
                      <legend>관리자 페이지</legend>
                         <ul>
                             <li>
                                 <label for="addTitle">제목 : </label>
                                 <input type="text" id="addTitle" name="addTitle" />
                             </li>
                             <li>
                                 <label for="addURL">URL : </label>
                                 <input type="text" id="addURL" name="addURL"/>
                             </li>
                             <li>
                                 <label for="addImg">썸네일 크기 320 x 306 pixels</label>
                                 <input type="file" id="addImg" name="addImg"/>
                             </li>
                             <li>
                                 <img src="" alt="" id="PreviewImg" />
                             </li>
                             <li>
                                 <input type="submit" value="저장" id="managerInsert"/>
                                 <input type="button" value="닫기" id="managerClose" />
                             </li>
                         </ul>
                     </fieldset>
                 </form>
             </section>
        </div>

        <ul class="collArea">
            <!--<li>
                <figure>
                    <span>x</span>
                    <img src="images/portfolio_2.jpg" alt="portfolio_2" />
                    <figcaption>
                        <h2>Chooper</h2>
                        <p>이동하기</p>
                    </figcaption>
                    <a href="#"></a>
                </figure>
            </li>-->
        </ul>


    <section class="popup01">
        <h2>관리자 접속</h2>
        <p>관리자 접속을 통해 포트폴리오를 <span> 추가 / 삭제 </span> 할 수 있습니다.</p>
        <p>비밀번호 : 01092931656</p>
        <label for="password">비밀번호 : </label><input type="password" id=""/><button>접속</button>

        <ul>
            <li><a href="#">하루동안 보지 않기</a></li>
            <li><a href="#">닫기</a></li>
        </ul>
    </section>

    <footer>Kim Sung Eun 2018</footer>

    <script>
        $(document).ready(function () {
            $('.popup01 ul li:last-of-type a').click(function () {
                $('.popup01').css('display', 'none');
            });
            var popupDate = new Date();
            popupDate.setTime(popupDate.getTime() + 1 * 10 * 1000);

            $('.popup01 ul li:first-of-type a').click(function () {
                $.cookie('popup01', '1', { expires: 1 });
                $('.popup01').css('display', 'none');
            });
            if ($.cookie('popup01') == 1) {
                $('.popup01').css('display', 'none');
            }

            // 관리자 접속
            $('.collArea').empty();
            $.ajax({
                type: "POST",
                url: 'common/config.php',
                dataType: 'json',
                success: function (args) {
                    password = args.list[0]["password"];
                    var date = new Date();
                    date.setTime(date.getTime() + 1 * 600 * 1000);
                    $(".popup01 input[type='password']").val('01092931656');
                    $(".popup01 button").click(function () {
                        var adminPassword = $(".popup01 input[type='password']").val();
                        if (adminPassword == '0' + password) {
                            alert('관리자는 10분동안 유지 됩니다.')
                            $.cookie('LOGIN', '1', { expires: date });
                            location.reload();
                        } else if (adminPassword == '') {
                            alert(password);
                            alert('비밀번호를 입력해주세요.')
                        } else {
                            alert('비밀번호가 틀렸습니다');
                        }
                    });
                }, error: function (e) {
                    alert('이런일은 없이');
                }
            });

            $('.collArea').empty();

            $.ajax({
                type: "POST",
                url: 'common/selectCollSlider.php',
                data: 'json',
                success: function (args) {
                    for (var i = 0; i < args.count - 1; i++) {
                        var item = args.list[i];

                        var seq = item["seq"];
                        var title = item["title"];
                        var link = item["link"];;
                        var thumb_saved = item["thumb_saved"];

                        //URL을 올릴떄 http:// 을 올리지 않아도 검사를 통해 http:// 가 없으면 넣어주는 조건식과 if문                          
                        var urlCheck = /^((http(s?))\:\/\/)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?$/;
                        if (urlCheck.test(link) == false) {
                            link = "http://" + link;
                        };
                  
                        var html = "<li>";
                        html = html + "<figure>";
                        html = html + "<span onclick='portfolioDelete(" + seq +")' title='삭제하기'>x</span>";
                        html = html + "<img src='thum/" + thumb_saved + "' alt='' id = 'thumb" + i + "'/>";
                        html = html + "<figcaption>";
                        html = html + "<h2>" + title + "</h2>";
                        html = html + "<div><p>이동하기</p></div>"
                        html = html + "<figcaption>";
                        html = html + "<a href=" + link + " target='_blank' title='이동하기'></a>";
                        html = html + "</figure>";
                        html = html + "</li>";
                   
                        $('.collArea').append(html);
                    }
                    if ($.cookie('LOGIN') == 1) {

                        $('.collArea li figure span').css('display', 'block');

                        
                    };
                }
            });

            // 쿠키가 1일때 추가하기 생성
            if ($.cookie('LOGIN') == 1) {
                $('.popup01').css('display', 'none');

                var html = "<li>";
                html = html + "<figure>";
                html = html + "<span title='관리자 로그아웃'>관리자 로그아웃</span>";
                html = html + "<img src='images/admin.jpg' alt=''/>";
                html = html + "<figcaption>";
                html = html + "<h2>추가하기</h2>";
                html = html + "<div><p>추가하기</p></div>"
                html = html + "<figcaption>";
                html = html + "<a href='#' title='추가하기'></a>";
                html = html + "</figure>";
                html = html + "</li>";
                $('.collArea').append(html);

                // 관리자 페이지 열기
                $('.collArea li:first-of-type figure a').click(function () {
                    $('.addArea_bg').css('display', 'block');
                });

                $('.collArea li:first-of-type span').click(function () {
                    if (confirm('로그아웃 하시겠습니까?')) {
                        $.cookie('LOGIN', '0');
                        location.reload();
                    }
                });

                $('#managerInsert').click(function () {
                    if ($.trim($("#addTitle").val()) == "") {
                        alert("제목을 입력해 주십시요.");
                        $('#addTitle').focus();
                        return false;
                    } else if ($.trim($("#addURL").val()) == "") {
                        alert("URL를 입력해 주십시요.");
                        $('#addURL').focus();
                        return false;
                    } else if ($("#addImg").val() == "") {
                        alert("썸네일 이미지를 입력해 주십시요.");
                        $('#addImg').focus();
                        return false;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: 'common/insert.php',
                            dataType: 'json',
                            data: FormData,
                            success: function (args) {
                                alert('성공');
                                location.reload();
                            },
                            error: function (e) {

                            }
                        }).submit();
                    }
                });

                var file = document.querySelector('#addImg');
                file.onchange = function () {
                    var fileList = file.files;
                    // 읽기
                    var reader = new FileReader();
                    reader.readAsDataURL(fileList[0]);
                    //로드 한 후
                    reader.onload = function () {
                        document.querySelector('#PreviewImg').src = reader.result;
                    };
                }; 

                // 관리자 페이지 닫기
                $(".addArea_bg .addArea form fieldset ul li input[type='button'").click(function () {
                    $('.addArea_bg').css('display', 'none');
                });
            };
            
            
            
        });

        // 포트폴리오 삭제 
        function portfolioDelete(seq) {
            if (confirm('삭제하시겠습니까?')) {
                if (seq <= 6) {
                    alert('삭제할 수 없는 게시물 입니다');
                } else {
                    $.ajax({
                        type: "POST",
                        url: 'common/delete.php',
                        dataType: 'json',
                        data: /*{ seq: testTest }*/"seq=" + seq,
                        success: function (args) {
                            alert("정상적으로 삭제 되었습니다.");
                            location.reload();
                        },
                        error: function (e) {
                            alert(e.responseText);
                        }
                    })
                }
            }
        }
    </script>

</body>
</html>