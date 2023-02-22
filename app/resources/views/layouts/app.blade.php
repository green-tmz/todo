<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                $("#search").submit(function(e) {
                    e.preventDefault()
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/tasks/search",
                        method: "POST",
                        data: {
                            'task': $("#name").val(),
                            'status': $("#status").val()
                        }
                    }).done(function(resp) {
                        let context = ''
                        $("#taskList").empty()

                        if (resp.length > 0) {
                            for(let i = 0; i < resp.length; i++) {

                                context += "<li class='list-group-item d-flex justify-content-between lh-sm'>" +
                                    "<div>" +
                                    "<h6 class='my-0'>"+resp[i].name+"</h6>"+
                                    "<small class='text-muted'>"+resp[i].user_name+"</small> - <small class='text-muted'>"+resp[i].project_name+"</small><br>" +
                                    "<small class='text-muted'>"+resp[i].status_name+"</small>" +
                                    "</div>"+

                                    "<span class='text-muted'>" +
                                        "<a href='/tasks/edit/"+resp[i].id+"'>" +
                                            "<i class='bi bi-pencil-square'></i>" +
                                        "</a>" +

                                        "<button onclick='delTask("+resp[i].id+")'>" +
                                            "<i class='bi bi-trash3-fill'></i>" +
                                        "</button>" +

                                    "</span>" +
                                "</li>"
                            }
                        } else {
                            context = "<li class='list-group-item d-flex justify-content-between lh-sm'>" +
                                    "<div>" +
                                    "<h6 class='my-0'>Задачи не найдены</h6>" +
                                    "</div>" +
                                "</li>"
                        }
                        // context = ""
                        $("#taskList").append(context);



                    });
                })
            })
            function delTask(id) {
                if (confirm('Удалить задачу?')) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/tasks/del/"+id,
                        type: "POST",
                        data: {
                            _method: 'delete',
                            'id': id,
                        }
                    }).done(function(resp) {
                        location.reload()
                    })
                }
            }

            function refresh() {
                location.reload()
            }

            function blockUser(id, status) {
                if (status == 0) {
                    if (confirm('Заблокировать пользователя?')) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/users/block",
                            type: "POST",
                            data: {
                                'id': id,
                                'status': status
                            }
                        }).done(function(resp) {
                            location.reload()
                        })
                    }
                } else {
                    if (confirm('Разблокировать пользователя?')) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "/users/block",
                            type: "POST",
                            data: {
                                'id': id,
                                'status': status
                            }
                        }).done(function(resp) {
                            location.reload()
                        })
                    }
                }

            }

            function delUser(id) {
                if (confirm('Удалить пользователя?')) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "/users/del/"+id,
                        type: "POST",
                        data: {
                            _method: 'delete',
                            'id': id,
                        }
                    }).done(function(resp) {
                        location.reload()
                    })
                }
            }
        </script>
    </body>
</html>
