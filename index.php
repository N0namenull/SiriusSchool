<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <title>Поиск задачи</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>
<body>
<div class="container mt-2">
    <p class="font-weight-bold text-secondary">Последние новости</p>
    <div class="row justify-content-center">
        <?php include 'news.php'; ?>
    </div>
</div>

<div class="container my-4">
    <h1>Поиск задачи</h1>
    <form action="" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="task_number" class="form-control" placeholder="Введите номер задачи">
            <button type="submit" class="btn btn-primary">Найти</button>
        </div>
    </form>

    <hr>

    <h3>Выберите номер задачи из выпадающего меню:</h3>
    <form action="" method="GET" class="mb-3">
        <div class="input-group">
            <select name="search" class="form-select">
                <option value="">-- Выберите номер задачи --</option>
                <?php
                $task_files = glob("tasks/*_*");
                $task_numbers = array();

                foreach ($task_files as $task_file) {
                    $task_name = basename($task_file);
                    $task_number = explode('_', $task_name)[0];

                    if (!in_array($task_number, $task_numbers)) {
                        echo '<option value="' . $task_number . '">' . $task_number . '</option>';
                        $task_numbers[] = $task_number;
                    }
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary">Показать</button>
        </div>
    </form>

    <?php
    function displayTask($files)
    {

        foreach ($files as $file) {
            $individ_num = explode('.', basename($file))[0];
            echo "<li style='list-style-type: none'>$individ_num</li>";
            $rash = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($rash, ['jpg', 'jpeg', 'png'])) {
                echo " <img class='mx-auto d-block img-fluid' src='$file' alt='Задача $individ_num'> ";
                solution($individ_num, $file);
            } else {
                echo '<div class="pdf-container mx-auto d-block">';
                echo '<canvas id="pdfCanvas_' . $individ_num . '"></canvas>';
                echo '</div>';
                echo "<div>
                <button id='prevPage_$individ_num' class='btn-primary btn'>Предыдущая страница</button>
                <span id='page-num_$individ_num'></span>
                <button id='nextPage_$individ_num' class='btn btn-primary'>Следующая страница</button>
                </div>";
                echo "<script>
                let currentPage_$individ_num = 1;
                let pdfFile_$individ_num = '$file';
                let pdfCanvas_$individ_num = document.getElementById('pdfCanvas_$individ_num');
                let pageNumSpan_$individ_num = document.getElementById('page-num_$individ_num');
                let prevPageButton_$individ_num = document.getElementById('prevPage_$individ_num');
                let nextPageButton_$individ_num = document.getElementById('nextPage_$individ_num');
                let countPages_$individ_num;

function renderPage_$individ_num(pageNumber) {
    pdfjsLib.getDocument(pdfFile_$individ_num).promise.then(function(pdf) {
        pdf.getPage(pageNumber).then(function(page) {
            let context = pdfCanvas_$individ_num.getContext('2d');
            let viewport = page.getViewport({ scale: 1.5 });
            pdfCanvas_$individ_num.height = viewport.height;
            pdfCanvas_$individ_num.width = viewport.width;
            let renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            page.render(renderContext);
            countPages_$individ_num = pdf.numPages;
            pageNumSpan_$individ_num.textContent = 'Страница ' + pageNumber + ' из ' + pdf.numPages;
        });
    });
}

        prevPageButton_$individ_num.addEventListener('click', function() {
            if (currentPage_$individ_num > 1) {
                currentPage_$individ_num--;
                renderPage_$individ_num(currentPage_$individ_num);
            }
        });
        
        nextPageButton_$individ_num.addEventListener('click', function() {
            if (currentPage_$individ_num < countPages_$individ_num) {
                currentPage_$individ_num++;
                renderPage_$individ_num(currentPage_$individ_num);
            }
        });
        
        renderPage_$individ_num(currentPage_$individ_num);
        </script>";
                solution($individ_num, $file);
            }
        }
    }
    function solution($individ_num, $file)
    {
        if (!empty(glob("tasks/{$individ_num}_resh.*"))) {
            echo '<div class="mt-3">';
            echo '<button class="btn btn-primary" id="showSolution_' . $individ_num . '"  onclick="toggleSolution(\'' . $individ_num . '\')" style="display: inline-block;">Показать решение</button>';
            echo '<button class="btn btn-primary mb-3" id="hideSolution_' . $individ_num . '" onclick="toggleSolution(\'' . $individ_num . '\')" style="display: none;">Скрыть решение</button>';

            echo '<div id="solution_' . $individ_num . '" style="display: none;">';;
                $individ_num = explode('.', basename($file))[0];
                $solution_files = glob("tasks/{$individ_num}_resh.*");
                foreach ($solution_files as $solution_file) {
                    $solution_ext = pathinfo($solution_file, PATHINFO_EXTENSION);
                    if (in_array($solution_ext, ['jpg', 'jpeg', 'png'])) {
                        echo " <img class='mx-auto d-block img-fluid' src='$solution_file' alt='Решение $individ_num'> ";
                    } else {
                        echo "<div>
                        <button id='prevPageSol_$individ_num' class='btn-primary btn'>Предыдущая страница</button>
                        <span id='page-numSol_$individ_num'></span>
                        <button id='nextPageSol_$individ_num' class='btn btn-primary'>Следующая страница</button>
                            </div>";
                        echo '<canvas id="solutionPdfCanvas_' . $individ_num . '"></canvas>';
                        echo "<script>
                        let solutionPdfFile_$individ_num = '$solution_file';
                        let solutionPdfCanvas_" . $individ_num . " = document.getElementById('solutionPdfCanvas_" . $individ_num . "');
                        let currentPageSol_" . $individ_num . "  = 1;
                        let pageNum_" . $individ_num . "  = document.getElementById('page-numSol_" . $individ_num . "');
                        let prevPageButtonSol_" . $individ_num . "  = document.getElementById('prevPageSol_" . $individ_num . "');
                        let nextPageButtonSol_" . $individ_num . "  = document.getElementById('nextPageSol_" . $individ_num . "');
                        let countSolutionPages_" . $individ_num . " ;
                        
                        function renderSolutionPage_$individ_num(pageNumber) {
                            pdfjsLib.getDocument(solutionPdfFile_$individ_num).promise.then(function(pdf) {
                                pdf.getPage(pageNumber).then(function(page) {
                                    let context = solutionPdfCanvas_$individ_num.getContext('2d');
                                    let viewport = page.getViewport({ scale: 1 });
                                    solutionPdfCanvas_$individ_num.height = viewport.height;
                                    solutionPdfCanvas_$individ_num.width = viewport.width;
                                    let renderContext = {
                                        canvasContext: context,
                                        viewport: viewport
                                    };
                                    page.render(renderContext);
                                    countSolutionPages_$individ_num = pdf.numPages;
                                    pageNum_$individ_num.textContent = 'Страница ' + pageNumber + ' из ' + pdf.numPages;
                                });
                            });
                        }
                        prevPageButtonSol_$individ_num.addEventListener('click', function() {
                        if (currentPageSol_$individ_num > 1) {
                            currentPageSol_$individ_num--;
                            renderSolutionPage_$individ_num(currentPageSol_$individ_num);
                                }   
                            });
            
                    nextPageButtonSol_$individ_num.addEventListener('click', function() {
                        if (currentPageSol_$individ_num < countSolutionPages_$individ_num) {
                            currentPageSol_$individ_num++;
                            renderSolutionPage_$individ_num(currentPageSol_$individ_num);
                                }
                            });
                        renderSolutionPage_$individ_num(currentPageSol_$individ_num);
                    </script>";

                    }
                }

            echo '</div>';
            echo '<script>
        function toggleSolution(individNum) {
            let solutionDiv = document.querySelector("#solution_" + individNum);
            let showButton = document.querySelector("#showSolution_" + individNum);
            let hideButton = document.querySelector("#hideSolution_" + individNum);
            
            if (solutionDiv.style.display === "none") {
                solutionDiv.style.display = "block";
                showButton.style.display = "none";
                hideButton.style.display = "inline-block";
                
            } else {
                solutionDiv.style.display = "none";
                showButton.style.display = "inline-block";
                hideButton.style.display = "none";
            }
        }


        </script>';


            echo '</div>';
        }

    }
    if (isset($_GET['task_number'])) {
        $selected_task_number = $_GET['task_number'];
        $selected_files = glob("tasks/*_{$selected_task_number}.*");
        $has_solution = !empty(glob("tasks/*_{$selected_task_number}_resh.*"));
        if (count($selected_files) > 0) {
            displayTask($selected_files);
        } else {
            echo '<p>Задачи с таким номером не найдены.</p>';
        }
    }

    if (isset($_GET['search'])) {
        $selected_task_number = $_GET['search'];
        $selected_files = glob("tasks/{$selected_task_number}_*[!_resh].*");
        $has_solution = !empty(glob("tasks/{$selected_task_number}_*_resh.*"));
        if (count($selected_files) > 0) {
            displayTask($selected_files);

        } else {
            echo '<p>Задачи с таким номером не найдены.</p>';
        }
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>
