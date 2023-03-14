<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Notification!!</h1>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
            </div>
            <div class="modal-body">
                <div class="alert alert-light" role="alert" id="notice2">
                    <script>
                        localStorage.setItem('notificationss', {{$notificationnumber}});
                    </script>

                </div>
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="location.href='/markasread/{{$authname}}/{{$authid}}';">Mark as Read</button>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">YOYO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
{{--                <button type="button" class="btn btn-primary" >--}}

{{--                </button>--}}
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary position-relative " data-bs-toggle="modal" data-bs-target="#exampleModal1">
                    Notification
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notf">
               <span class="visually-hidden">unread messages</span></span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Notification</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="notice">
                                <ul class="list-group">
                                    @if($notificationnumber!=0)
                                    @foreach($notflist as $notf)
                                                 <li class="list-group-item">
                                                     {{$notf}}
                                                 </li>
                                    @endforeach
                                    @else
                                        <li class="list-group-item">No notification</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="modal-footer">
{{--                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                                <button type="button" class="btn btn-primary" onclick="location.href='/markasread/{{$authname}}/{{$authid}}';">Mark as Read</button>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>


