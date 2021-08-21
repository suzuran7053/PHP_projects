<!-- WORD MODAL -->
<?php addWordListModal(); ?>
        
<div class="col-md-10 mx-auto px-5 mb-5 wordlist" style="margin-top: 70px;">
    <h1 class="mb-5 display-4">
        My Word List
        <a href="" class="ml-4" data-toggle="modal" data-target="#newWord"><i class="fas fa-plus text-warning"></i></a>
    </h1>

    <div class="topnav">
        <a class="active" href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <input type="text" placeholder="Search..">
    </div>

    <form actionr="" method="post">
        <table class="center table table-sm table-striped text-center">
            <thead>
                <tr>
                    <th><input name="check_all_words" type="checkbox" id="checkAllWords"></th>
                    <th><i class="fas fa-flag"></i></th>
                    <th width="25%">Words</th>
                    <th width="25%">Definition</th>
                    <th width="30%">Comments</th>
                    <th><i class="fas fa-bullhorn"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_SESSION["user_id"])) {
                    $user_id = $_SESSION["user_id"];
                }
                $query = "SELECT * FROM words WHERE word_user_id=$user_id";
                $select_my_words = mysqli_query($dbc, $query);
                checkQuery($select_my_words);
                while ($row = mysqli_fetch_assoc($select_my_words)) {
                    $word_name = $row["word_name"];
                    $word_definition = $row["word_definition"];
                    $word_memo = $row["word_memo"];
                    $word_topic_name = $row["word_topic_name"];
                    $word_flag_id = $row["word_flag_id"];
                    $word_remind = $row["word_remind"];
                    $word_date = $row["word_date"];
                    $word_user_id = $row["word_user_id"];

                ?>
                    <tr>
                        <td><input name="check_box" class="checkBox" value="" type="checkbox"></td>
                        <td><?php echo $word_flag_id; ?></td>
                        <td><?php echo $word_name; ?></td>
                        <td><?php echo $word_definition; ?></td>
                        <td><?php echo $word_memo; ?></td>
                        <td><?php echo $word_remind; ?>Days time</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </form>