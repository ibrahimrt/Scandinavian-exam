<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Scandinavian-Travel Test</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Styles -->
        <style>
            .titleName{
                color: #9013fe;
                font-weight: bold;
            }
            .dropdown-toggle::after {
                display: none;
            }
            .fs-14{
                font-size: 14px;
            }
            #dropdownMenu2[aria-expanded="true"] .switchIcon:before {
                content:'north';              
            }
            #dropdownMenu2[aria-expanded="false"] .switchIcon:before {
                content:'south';                
            }
            .bodyContainer{
                margin: 0 auto;
                max-width: 1350px;
            }
            .buttonExcel, .buttonExcel:hover, .buttonExcel:active, .buttonExcel:visited {
                background-color: #9013fe;
                max-width: 140px;
                width: 100%;
                color: white;
            }
            mark {
                background-color: #ffee54;
                padding:0;
            }
            
        </style>
    </head>
    <body class="bodyContainer antialiased bg-default mt-2 d-flex flex-column">
        <div class="row d-flex">
            <div class="col-auto m-3 ">
                <input type="text" class="form-control" id="search" placeholder="Search" onKeyUp="filterList()">
            </div>
            <div class="col-auto m-3 ">
                <div class="dropdown open">
                    <button class="btn btn-light dropdown-toggle d-flex justify-content-between" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 150px;">

                        <span id="groupSelected">Group</span>
                        <span class="material-icons fs-14 switchIcon d-flex align-self-center"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2" id="dropdownList">
                        
                    </div>
                </div>
            </div>
            <div class="col-2"  style="flex:1 ">
                <div class="d-flex justify-content-end " >
                    <button type="button" class="btn buttonExcel m-3 " onclick="excelTranslations()" >
                        Excel
                    </button>
                </div>
            </div>
        </div>
        
        
        <table class="table table-hover " style="max-width:1580px;">
            <thead class ="table-light">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">ENGLISH</th>
                    <th scope="col">ESPAÑOL</th>
                    <th scope="col">DEUTSCH</th>
                    <th scope="col">FRANÇAIS</th>
                    <th scope="col">ITALIANO</th>
                    <th scope="col">DANSK</th>
                </tr>
            </thead>
            <tbody id="content-table">

            </tbody>
        </table>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title titleName" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-striped " style="max-width:1580px;">
                            <tbody id="content-table-detail">
                                <tr>
                                    <td>English</td>
                                    <td id="en-lg"></td>
                                </tr>
                                <tr>
                                    <td>Español</td>
                                    <td id="es-lg"></td>
                                </tr>
                                <tr>
                                    <td>Deutsch</td>
                                    <td id="de-lg"></td>
                                </tr>
                                <tr>
                                    <td>Français</td>
                                    <td id="fr-lg"></td>
                                </tr>
                                <tr>
                                    <td>Italiano</td>
                                    <td id="it-lg"></td>
                                </tr>
                                <tr>
                                    <td>Dansk</td>
                                    <td id="da-lg"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                
                </div>
            </div>
        </div>
        
    </body>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            getTranslations()
            getGroups()
        });

        var route = "{{url('api/getRequestAPI')}}"
        var apiUrl = "https://practical-neumann.62-151-178-253.plesk.page/api/"     
        var translations = {};
        var filteredDataCached = {};

        function getTranslations() {            
            var apiRoute = "translations"

            $.ajax({                
                url: route,
                type: 'GET',
                dataType: 'json',
                data:{apiUrl, apiRoute},
                success: function(response){
                    let list = response.data
                    translations = list
                    document.getElementById('content-table').innerHTML = ''
                    list.map(x => {
                        document.getElementById('content-table').innerHTML +='<tr><td class="titleName" onClick="showDetail(\''+ x.full_key+'\')">'+
                                x.full_key +'</td><td>'+ x.text.en +'</td><td>'+ x.text.es +'</td><td>'+
                                x.text.en +'</td><td>'+ x.text.en +'</td><td>'+ x.text.en +'</td><td>'+
                                x.text.en +'</td></tr>'
                        }
                    )
                    //Contando los elementos que vienen en cada posicion del arreglo x.text
                    //Siempre obtenía el número 2, como no conozco las claves con las que pueden venir las otras traducciones
                    //Utilizo por defecto 'en' en todas las demas 
                }
            });
        }
        function getGroups() {
            var apiRoute = "translationgroups"

            $.ajax({                
                url: route,
                type: 'GET',
                dataType: 'json',
                data:{apiUrl, apiRoute},
                success: function(response){
                    let list = response.data                    
                    list.map(x => {
                            const dropDown = document.getElementById('dropdownList')
                            const button = document.createElement('button')
                            button.setAttribute('class', 'dropdown-item')
                            button.onclick = function(){filterGroups()}
                            button.innerHTML = x
                            dropDown.appendChild(button)
                        }
                    )
                }
            });
        }

        function filterGroups(group) {
            group = this.event.currentTarget.innerHTML
            var apiRoute = "translations?group="+group
            document.getElementById("groupSelected").innerText = group

            $.ajax({                
                url: route,
                type: 'GET',
                dataType: 'json',
                data:{apiUrl, apiRoute},
                success: function(response){
                    let list = response.data
                    translations = list
                    filteredDataCached = list
                    document.getElementById('content-table').innerHTML =''
                     list.map(x => 
                        document.getElementById('content-table').innerHTML +='<tr><td class="titleName" onClick="showDetail(\''+ x.full_key+'\')">'+ x.full_key +'</td><td>'+ x.text.en +'</td><td>'+ x.text.es +'</td><td>'+ x.text.en +'</td><td>'+ x.text.en +'</td><td>'+ x.text.en +'</td><td>'+ x.text.en +'</td></tr>'
                    )
                }
            });
        }
        function showDetail(key){
            var apiRoute = "translations/"+key;
            var modalDetail = new bootstrap.Modal(document.getElementById('exampleModal'))

            $.ajax({                
                url: route,
                type: 'GET',
                dataType: 'json',
                data:{apiUrl, apiRoute},
                success: function(response){
                    let list = response.data
                    document.getElementsByClassName('modal-title').item('h5').innerHTML = response.data.full_key
                    document.getElementById('en-lg').innerText = response.data.text.en
                    document.getElementById('es-lg').innerText = response.data.text.es
                    document.getElementById('de-lg').innerText = response.data.text.en
                    document.getElementById('fr-lg').innerText = response.data.text.en
                    document.getElementById('it-lg').innerText = response.data.text.en
                    document.getElementById('da-lg').innerText = response.data.text.en
                    modalDetail.show()                   
                }
            });
        }
        
        function filterList() {
            var inputText = document.getElementById("search").value;
            
            if (inputText.trim().length == 0  ) {
                const search = document.getElementById('search');
                search.disabled = true;
                document.getElementById('content-table').innerHTML = ''
                    translations.map(x => {
                        document.getElementById('content-table').innerHTML +='<tr><td class="titleName" onClick="showDetail(\''+ x.full_key+'\')">'+
                                x.full_key +'</td><td>'+ x.text.en +'</td><td>'+ x.text.es +'</td><td>'+
                                x.text.en +'</td><td>'+ x.text.en +'</td><td>'+ x.text.en +'</td><td>'+
                                x.text.en +'</td></tr>'
                        }
                    )
                search.disabled = false;
                filteredDataCached = {};
                return;
            }

            const toSearch = inputText.toLowerCase().trim();
            const regex = new RegExp('(' + toSearch + ')', 'gi');
            var filteredData = [];
            for (let i = 0; i < translations.length; i++) {
                if (isNaN(translations[i].text.es)) {
                    translateEsp = translations[i].text.es.toLowerCase()
                    translateEn = translations[i].text.en.toLowerCase()
                    if (translateEsp.includes('&#169;') || translateEn.includes('&#169;')) {
                        translateEsp = translateEsp.replace(/&#169;/g, '')
                        translateEn = translateEn.replace(/&#169;/g, '')
                    }
                } else {
                    translateEsp = translations[i].text.es.toString()
                    translateEn = translations[i].text.en.toString()
                }
                if (translations[i].full_key.indexOf(toSearch) != -1 || translateEsp.indexOf(toSearch) != -1 || translateEn.indexOf(toSearch) != -1) {
                    if (!filteredData.includes(translations[i])) {
                        filteredData.push(translations[i])
                    }
                }
            }
            filteredDataCached = filteredData;
            var contentTable = document.getElementById('content-table');
            contentTable.innerHTML = '';
            filteredData.map(x => {
                var fullKey = x.full_key.replace(regex, '<mark>$1</mark>');                
                var enText = x.text.en.toString().replace(regex, '<mark>$1</mark>');               
                var esText = x.text.es.toString().replace(regex, '<mark>$1</mark>');
                contentTable.innerHTML += '<tr><td class="titleName" onClick="showDetail(\''+ x.full_key+'\')">' + fullKey +
                '</td><td>' + enText + '</td><td>' + esText + '</td><td>' + enText +
                '</td><td>' + enText + '</td><td>' + enText + '</td><td>' + enText +
                '</td></tr>';
            });
        }

        function excelTranslations() { 
            var routeExcel = "{{url('api/dataExport')}}";
            var data = filteredDataCached ? filteredDataCached : translations;
            debugger;
            var filter = {
                data
            }
            var url = "{{URL::to('api/dataExport')}}?" + $.param(filter)
            window.location = url;
        }
        
        
    </script>

</html>
