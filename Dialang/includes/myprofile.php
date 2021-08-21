<?php 
    // DELETE POST IF CLICKED
    deletePost();  
?>



        
<div class="col-md-10 mx-auto px-5 mb-5" style="margin-top: 70px;">    
    <h1 class="mb-5 display-4">My Page</h1>    
    <div class="row align-items-center justify-content-center text-center mb-5">
        <div class="col-md-3">
            <img src="./images/<?php echo $_SESSION["user_image"]; ?>" alt="" width="90%" class="img-fluid rounded-circle">
        </div>
        <div class="col-md-6">
            <ul>
                <li>
                    <h2 class="bung"><?php echo $_SESSION["user_name"]; ?></h2>
                </li>
                <li class="mt-2"><b class="mr-5"><i class="pink mr-1 fas fa-award"></i>Level: <?php echo $_SESSION["user_level"]; ?></b><small>Joined: <time><?php echo date("Y/n/j", strtotime($_SESSION["user_joined"])); ?></time></small></li>
                <li class="mt-3">
                    <h5>My Target: <strong><?php echo $_SESSION["user_target"]; ?></strong></h5>
                </li>
                <?php
                if(isset($_SESSION["user_lang"]) && isset($_SESSION["user_nlang"])){
                    $lang_id = $_SESSION["user_lang"];
                    $nlang_id = $_SESSION["user_nlang"];
                    $query = "SELECT * FROM languages WHERE la_id=$lang_id OR la_id=$nlang_id";
                    $get_lang_name = mysqli_query($dbc, $query);
                    
                    checkQUery($get_lang_name);
                    while($row = mysqli_fetch_array($get_lang_name)){
                        if($row["la_id"]==$lang_id){
                            $lang_name = $row["la_name"];
                        }else if($row["la_id"]==$nlang_id){
                            $nlang_name = $row["la_name"];
                        }
                    }
                }
                ?>
                <li class="mt-3"><h5>Natioinal Language:<?php echo $nlang_name; ?></h5></li>
                <li class="mt-2"><h5>Language I'm learning:<?php echo $lang_name; ?></h5></li>
            </ul>
        </div>
    </div>
    <div class="row mt-5 justify-content-center text-center">
        <div class="col-sm-3">
        <?php  //GET HOW MANY POST THE USER MADE
            if(isset($_SESSION["user_name"])){
                $user_id = $_SESSION["user_id"];
                $query = "SELECT * FROM posts WHERE post_author_id=$user_id";
                $get_user_post_count = mysqli_query($dbc,$query);
                $post_count = mysqli_num_rows($get_user_post_count);
            }
        ?>
            <div class="bung data"><span><?php echo $post_count; ?></span></div>
            <span>posts</span>
        </div>

        <!-- 以下の意向も雲、上記と同様にcorrectionsテーブルからデータ数を引き出して実装する。そのほうが確実でずれが起こる心配がない。
        　　　corretionsテーブルを作ってから。-->
        <div class="col-sm-3">
            <div class="bung data"><span><?php echo $_SESSION["user_made_corrections"]; ?></span></div>
            <span>corrections made</span>
        </div>
        <div class="col-sm-3">
            <div class="bung data"><span><?php echo $_SESSION["user_got_corrections"]; ?></span></div>
            <span>corrections recieved</span>
        </div>
    </div>

    <div class="row mt-5">
            <!-- GOOGLE CALENDAR
        https://developers.google.com/chart/interactive/docs/gallery/calendar  -->
            <script type="text/javascript">
                google.charts.load("current", {packages:["calendar"]});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var dataTable = new google.visualization.DataTable();
                    dataTable.addColumn({ type: 'date', id: 'Date' });
                    dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
                    dataTable.addRows([
                        [ new Date(2021, 1, 13), 37032 ],
                        [ new Date(2021, 1, 14), 38024 ],
                        [ new Date(2021, 1, 15), 38024 ],
                        [ new Date(2021, 1, 16), 38108 ],
                        [ new Date(2021, 1, 17), 38229 ],                    
                        [ new Date(2021, 1, 23), 38345 ],
                        [ new Date(2021, 1, 24), 38436 ],
                        [ new Date(2021, 1, 30), 38447 ],
                        [ new Date(2021, 2, 4), 38177 ],
                        [ new Date(2021, 2, 5), 38705 ],
                        [ new Date(2021, 2, 12), 38210 ],
                        [ new Date(2021, 2, 13), 38029 ],
                        [ new Date(2021, 2, 19), 38823 ],
                        [ new Date(2021, 2, 23), 38345 ],
                        [ new Date(2021, 2, 24), 38436 ],
                        [ new Date(2021, 2, 30), 38447 ],
                        [ new Date(2021, 3, 13), 37032 ],
                        [ new Date(2021, 3, 14), 38024 ],
                        [ new Date(2021, 3, 15), 38024 ],
                        [ new Date(2021, 3, 16), 38108 ],
                        [ new Date(2021, 3, 17), 38229 ], 
                        ]);

                    var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

                    var options = {
                        title: "ACTIVITIES",
                        height: 350,
                    };

                    chart.draw(dataTable, options);
                }
            </script>
            <div id="calendar_basic" class="mx-auto" style="width: 'auto'; height: 350px;"></div>       

    </div>


    <!-- MY LATEST POSTS -->
    <h2 class="bung mt-5">My Latest Posts</h2>
    <div class="row justify-content-around">

        <?php  // GET MY LATEST POSTS
        getMyLatestPosts();    ?>

    </div>
</div>