<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Event Backend</title>

    <base href="{{ asset('')}}">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles -->
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="events/index.html">Nền tảng sự kiện</a>
    <span class="navbar-organizer w-100">{{$events->name}}</span>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" id="logout" href="index.html">Đăng xuất</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{route('events')}}">Quản lý sự kiện</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>{{$events->name}}</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="events/detail.html">Tổng quan</a></li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Báo cáo</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item"><a class="nav-link" href="reports/index.html">Công suất phòng</a></li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="border-bottom mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h1 class="h2">{{$events->name}}</h1>
                </div>
                <span class="h6">{{date('d-m-Y', strtotime($events->date))}}</span>
            </div>

            <div class="mb-3 pt-3 pb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <h2 class="h4">Tạo vé mới</h2>
                </div>
            </div>
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="needs-validation" novalidate action="{{route('tickets.store', ['id' => $id])}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="inputName">Tên</label>
                        <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                        @if(!$errors->has('cost'))
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="" value="">
                        @else
                        <input type="text" class="form-control is-invalid" id="inputName" name="name" placeholder="" value="">
                        <div class="invalid-feedback">
                            Tên không được để trống.
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        @if(!$errors->has('cost'))
                        <label for="inputCost">Giá</label>
                        <input type="number" class="form-control" id="inputCost" name="cost" placeholder="" value="0">
                        @else
                        <input type="number" class="form-control is-invalid" id="inputCost" name="cost" placeholder="" value="0">
                        <div class="invalid-feedback">
                            Giá không được để trống.
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <label for="selectSpecialValidity">Hiệu lực đặc biệt</label>
                        <select class="form-control" id="selectSpecialValidity" name="special_validity">
                            <option value="" selected>Không</option>
                            <option value="amount">Số lượng giới hạn</option>
                            <option value="date">Có thể mua đến ngày</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        @if(!$errors->has('cost'))
                        <label for="inputAmount">Số lượng vé tối đa được bán</label>
                        <input type="number" class="form-control" id="inputAmount" name="amount" placeholder="" value="0">
                        @else
                        <input type="number" class="form-control is-invalid" id="inputAmount" name="amount" placeholder="" value="0">
                        <div class="invalid-feedback">
                            Vé không được để trống.
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        @if(!$errors->has('cost'))
                        <label for="inputValidTill">Vé có thể được bán đến</label>
                        <input type="text"
                               class="form-control"
                               id="inputValidTill"
                               name="valid_until"
                               placeholder="yyyy-mm-dd HH:MM"
                               value="">
                               @else
                               <input type="text"
                               class="form-control is-invalid"
                               id="inputValidTill"
                               name="valid_until"
                               placeholder="yyyy-mm-dd HH:MM"
                               value="">
                               <div class="invalid-feedback">
                                Vé không được để trống.
                                </div>
                               @endif
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary" type="submit">Lưu vé</button>
                <a href="events/detail.html" class="btn btn-link">Bỏ qua</a>
            </form>

        </main>
    </div>
</div>
<script>
    let checkValid = document.querySelector('#selectSpecialValidity');
    let amount = document.querySelector('#amount'); 
    let date = document.querySelector('#date');
    checkValid.addEventListener('change', ()=>{
        if(checkValid.value == "date"){
        amount.classList.add('d-none');
        date.classList.remove('d-none');
    }else if(checkValid.value == "amount"){
        amount.classList.remove('d-none');
        date.classList.add('d-none');
    }else{
        amount.classList.remove('d-none');
        date.classList.remove('d-none');
    }
    });
</script>
</body>
</html>
