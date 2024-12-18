@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách thanh toán</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách thanh toán</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('payment.list')}}" class="btn btn-outline-success"> Tất cả thanh toán </a>
        </div>
        <div class="col-sm-6 my-3">
            <form class="search-form float-end" action="{{route('payment.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tìm kiếm..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('payment.list')}}" class="row align-middle" method="post" id="itemsPerPageForm">
                @csrf
                <div class="col-6 col-sm-2">
                    <label for="">Phương thức thanh toán</label>
                    <select name="filterMethod" id="filterMethod" class="form-select" onchange="submitForm()">
                        <option value="{{ request()->input('filterMethod')}}">{{ request()->input('filterMethod') ?? 'Chọn phương thức'}}</option>
                        <option value="MoMo">MoMo</option>
                        <option value="VNPAY">VNPAY</option>
                        <option value="ZALOPAY">ZALOPAY</option>
                    </select>
                </div>
                <div class="col-6 col-sm-2">
                    <label for="">Trạng thái thanh toán</label>
                    <select name="filterStatus" id="filterStatus" class="form-select" onchange="submitForm()">
                        <option value="{{ request()->input('filterStatus')}}">{{ request()->input('filterStatus') ?? 'Chọn trạng thái'}}</option>
                        <option value="Đang thanh toán">Đang thanh toán</option>
                        <option value="Thành công">Thành công</option>
                        <option value="Thất bại">Thất bại</option>
                    </select>
                </div>
                <div class="col-6 col-sm-2">
                    <label for="">Từ ngày</label>
                    <input type="date" name="filterCreateStart" class="form-control" value="{{request()->input('filterCreateStart') ? request()->input('filterCreateStart') : ''}}" onchange="submitForm()">
                </div>
                <div class="col-6 col-sm-2">
                    <label for="">Đến ngày</label>
                    <input type="date" name="filterCreateEnd" class="form-control" value="{{request()->input('filterCreateEnd') ? request()->input('filterCreateEnd') : ''}}" onchange="submitForm()">
                </div>
            </form>
        </div>
    </div>
    <table class="table text-center mt-3" id="myTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã thanh toán</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Ngày thanh toán</th>
                <th scope="col">Phương thức thanh toán</th>
                <th scope="col">Số tiền thanh toán</th>
                <th scope="col">Tài khoản thanh toán</th>
                <th scope="col">Trạng thái thanh toán</th>
            </tr>
        </thead>
        <tbody>
            @if (count($payments))
            @foreach($payments as $index=>$payment)
            <tr>
                <td>{{$payments->firstItem()+$index  }}</td>
                <td>{{$payment->pay_id}}</td>
                <td>{{$payment->description}}</td>
                <td>{{$payment->payment_date}}</td>
                <td>{{$payment->payment_method}}</td>
                <td>{{number_format($payment->amount)}} VNĐ</td>
                <td>{{$payment->user->name}}</td>
                <td>
                    <form action="{{ route('payment.update', $payment->id) }}" method="POST">
                        @csrf
                        <select name="payment_status" class="form-select {{ $payment->payment_status == 'Đang thanh toán' ? 'bg-warning' : ($payment->payment_status == 'Thành công' ? 'bg-success' : 'bg-danger') }} text-white" onchange="this.form.submit()">
                            <option value="Đang thanh toán" {{ $payment->payment_status == 'Đang thanh toán' ? 'selected' : '' }}>Đang thanh toán</option>
                            <option value="Thành công" {{ $payment->payment_status == 'Thành công' ? 'selected' : '' }}>Thành công</option>
                            <option value="Thất bại" {{ $payment->payment_status == 'Thất bại' ? 'selected' : '' }}>Thất bại</option>
                        </select>
                    </form>
                </td>


            </tr>

            @endforeach
            @else
            <tr class="text-center">
                <td colspan="10">Không có dữ liệu</td>
            </tr>
            @endif
        </tbody>
    </table>

</div>
<div class="pagination-area" style="display: flex; justify-content: center; align-items: center;">
    <ul class="pagination">
        {{$payments->links('pagination::bootstrap-5')}}
    </ul>
</div>

@endsection
@section('js')
<script>

    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }
</script>
@endsection
