
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
        function Overveiw() {
            document.getElementById("overveiw").style.backgroundColor = "orangered";
            document.getElementById("overveiw").style.color = "white";
            document.getElementById("curriculum").style.backgroundColor = "#ededee";
            document.getElementById("curriculum").style.color = "black";
            document.getElementById("instructor").style.backgroundColor = "#ededee";
            document.getElementById("instructor").style.color = "black";
            document.getElementById("faq").style.backgroundColor = "#ededee";
            document.getElementById("faq").style.color = "black";
            document.getElementById("review").style.backgroundColor = "#ededee";
            document.getElementById("review").style.color = "black";
        }

        function Curriculum() {
            document.getElementById("overveiw").style.backgroundColor = "#ededee";
            document.getElementById("overveiw").style.color = "black";
            document.getElementById("curriculum").style.color = "white";
            document.getElementById("curriculum").style.backgroundColor = "orangered";
            document.getElementById("instructor").style.backgroundColor = "#ededee";
            document.getElementById("instructor").style.color = "black";
            document.getElementById("faq").style.backgroundColor = "#ededee";
            document.getElementById("faq").style.color = "black";
            document.getElementById("review").style.backgroundColor = "#ededee";
            document.getElementById("review").style.color = "black";
        }
        function Instructor() {
            document.getElementById("overveiw").style.backgroundColor = "#ededee";
            document.getElementById("curriculum").style.color = "black";
            document.getElementById("curriculum").style.backgroundColor = "#ededee";
            document.getElementById("overveiw").style.color = "black";
            document.getElementById("instructor").style.backgroundColor = "orangered";
            document.getElementById("instructor").style.color = "white";
            document.getElementById("faq").style.backgroundColor = "#ededee";
            document.getElementById("faq").style.color = "black";
            document.getElementById("review").style.backgroundColor = "#ededee";
            document.getElementById("review").style.color = "black";
        }
        function Faq() {
            document.getElementById("overveiw").style.backgroundColor = "#ededee";
            document.getElementById("curriculum").style.color = "black";
            document.getElementById("curriculum").style.backgroundColor = "#ededee";
            document.getElementById("overveiw").style.color = "black";
            document.getElementById("instructor").style.backgroundColor = "#ededee";
            document.getElementById("instructor").style.color = "black";
            document.getElementById("faq").style.backgroundColor = "orangered";
            document.getElementById("faq").style.color = "white";
            document.getElementById("review").style.backgroundColor = "#ededee";
            document.getElementById("review").style.color = "black";
        }
        function Review() {
            document.getElementById("overveiw").style.backgroundColor = "#ededee";
            document.getElementById("overveiw").style.color = "black";
            document.getElementById("curriculum").style.color = "black";
            document.getElementById("curriculum").style.backgroundColor = "#ededee";
            document.getElementById("instructor").style.color = "black";
            document.getElementById("instructor").style.backgroundColor = "#ededee";
            document.getElementById("faq").style.backgroundColor = "#ededee";
            document.getElementById("faq").style.color = "black";
            document.getElementById("review").style.backgroundColor = "orangered";
            document.getElementById("review").style.color = "black";
        }

    </script>
    <style>
        .btn-group .btn {
            padding: 15px;
            text-align: center;
        }

        .btn:hover {
            background-color: orangered;
            color: white;
        }

        .mani {
            color: orangered;
            font-size: 20px;
            margin: 10px;
        }

        .card {
            margin-top: 80px;
            margin-left: 30px;
        }

        .no {
            font-size: 15px;
            color: rgb(126, 124, 124);
            text-align: center;
        }

        .buyButton {
            height: 40px;
            width: 50%;
            margin-left: 100px;
            color: orangered;
        }

        .buyButton:hover {
            color: white;
        }

        .rupeeButton {
            width: 50%;
            margin-left: 100px;
            height: 40px;
        }

        .active {
            background-color: orangered;
            color: white;
        }
    </style>

</head>

<body><br><br><br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-sm-7">
                <div class="btn-group" id="myDiv">
                    <a href="<?php echo base_url()?>welcome/overview" target="iframe"><button id="overveiw" onclick="Overveiw()" type="button"
                            class="btn active" style="padding-right: 30px;padding-left: 30px;">Overveiw</button></a>

                    <a href="<?php echo base_url()?>welcome/overview" target="iframe"><button id="curriculum" onclick="Curriculum()"
                            type="button" class="btn btn-light"
                            style="padding-right: 30px;padding-left: 30px;">Curriculum</button></a>

                    <a href="<?php echo base_url()?>welcome/overview" target="iframe"><button id="instructor" onclick="Instructor()"
                            type="button" class="btn btn-light"
                            style="padding-right: 30px;padding-left: 30px;">Instructor</button></a>

                    <a href="<?php echo base_url()?>welcome/overview" target="iframe"> <button id="faq" type="button" onclick="Faq()"
                            class="btn btn-light" style="padding-right: 30px;padding-left: 30px;">FAQ</button></a>

                    <a href="<?php echo base_url()?>welcome/overview" target="iframe"><button id="review" type="button" onclick="Review()"
                            class="btn btn-light" style="padding-right: 30px;padding-left: 30px;">Reviews</button></a>
                </div>
                <div>
                    <iframe src="<?php echo base_url()?>welcome/overview" id="iframe" name="iframe" frameborder="0"
                        style="width: 100%;height: 1300px;overflow-x: hidden;"></iframe>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="card">
                    <table class="table table-borderless">
                        <tr>
                            <td><span style="color: rgb(126, 124, 124);"><i class="fas fa-copy mani"></i>Lectures</span>
                            </td>
                            <td class="no" style="padding-top: 20px;">3</td>
                        </tr>
                        <tr>
                            <td><span style="color: rgb(126, 124, 124);"><i
                                        class="fas fa-puzzle-piece mani"></i>Quizzes</span></td>
                            <td class="no" style="padding-top: 20px;">0</td>
                        </tr>
                        <tr>
                            <td><span style="color: rgb(126, 124, 124);"><i
                                        class="fas fa-clock mani"></i>Duration</span></td>
                            <td class="no" style="padding-top: 20px;">10 week</td>
                        </tr>
                        <tr>
                            <td><span style="color: rgb(126, 124, 124);"><i
                                        class="fas fa-users mani"></i>Students</span></td>
                            <td class="no" style="padding-top: 20px;">21</td>
                        </tr>
                        <tr>
                            <td><span style="color: rgb(126, 124, 124);"><i
                                        class="fas fa-pen-square mani"></i>Assesment</span></td>
                            <td class="no" style="padding-top: 20px;">Yes</td>
                        </tr>
                    </table>
                </div> <br><br>
                <button type="button" class="btn rupeeButton" style="background-color: orangered;color: white;"> <span
                        class="fas fa-rupee-sign"></span>35000</button><br><br>
                <a href="<?php echo base_url() ?>welcome/login"> <button type="button" class="btn btn-outline-danger buyButton">BUY NOW</button>
                </a>
            </div>
        </div>

    </div>
