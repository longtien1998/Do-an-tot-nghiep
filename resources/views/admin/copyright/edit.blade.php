@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Cập nhật bản quyền</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật bản quyền</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5>Thông báo !</h5>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form class="form-horizontal form-material row" id="submit" method="POST" action="{{route('copyrights.update',$copyright->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Bài hát</label>
                    <div class="col-md-12">
                        <select class="form-select" name="song_id" id="song_id" aria-label="Default select example" disabled>
                            <option value="{{$copyright->song_id}}" selected>{{$copyright->song->song_name}}</option>
                            @foreach ( $songs as $song)
                            <option value="{{$song->id}}">{{$song->song_name}}</option>
                            @endforeach


                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Nhà xuất bản</label>
                    <div class="col-md-12">
                        <select class="form-select" name="publisher_id" id="publisher_id" aria-label="Default select example" disabled>
                            <option value="{{$copyright->publisher_id}}" selected>{{$copyright->publisher->publisher_name}}</option>
                            @foreach ( $publishers as $publisher)
                            <option value="{{$publisher->id}}">{{$publisher->publisher_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Loại giấy phép</label>
                    <div class="col-md-12">
                        <select name="license_type" id="license_type" value="" class="form-select" aria-label="Default select example" disabled>
                            <option value="{{$copyright->license_type}}">{{$copyright->license_type}}</option>
                            <option value="Mechanical License (Giấy phép cơ học)">Mechanical License (Giấy phép cơ học)</option>
                            <option value="Performance License (Giấy phép biểu diễn công cộng)">Performance License (Giấy phép biểu diễn công cộng)</option>
                            <option value="Synchronization License (Sync License) (Giấy phép đồng bộ hóa)">Bản quyền sao chép</option>
                            <option value="Master License (Giấy phép bản gốc)">Master License (Giấy phép bản gốc)</option>
                            <option value="Print License (Giấy phép in ấn)">Print License (Giấy phép in ấn)</option>
                            <option value="Compulsory License (Giấy phép bắt buộc)">Compulsory License (Giấy phép bắt buộc)</option>
                            <option value="Sampling License (Giấy phép sử dụng mẫu)">Protected License (Giấy phép bảo vệ)</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Ngày phát hành</label>
                    <div class="col-md-12">
                        <input type="date" name="issue_day" id="issue_day" value="{{ $copyright->issue_day ? $copyright->issue_day->format('Y-m-d') : '' }}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Ngày hết hạn</label>
                    <div class="col-md-12">
                        <input type="date" name="expiry_day" id="expiry_day" value="{{ $copyright->expiry_day ? $copyright->expiry_day->format('Y-m-d') : '' }}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Quyền sử dụng</label>
                    <div class="col-md-12">
                        <input type="text" name="usage_rights" id="usage_rights" value="{{$copyright->usage_rights}}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Giá chuyển nhượng</label>
                    <div class="col-md-12">
                        <input type="number" name="price" id="price" value="{{$copyright->price}}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Hình thức thanh toán</label>
                    <div class="col-md-12">
                        <input type="text" name="payment" id="payment" value="{{$copyright->payment}}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Địa điểm thanh toán</label>
                    <div class="col-md-12">
                        <input type="text" name="location" id="location" value="{{$copyright->location}}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Thời gian thanh toán</label>
                    <div class="col-md-12">
                        <input type="date" name="pay_day" id="pay_day" value="{{ $copyright->pay_day ? $copyright->pay_day->format('Y-m-d') : '' }}" class="form-control form-control-line" disabled>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <label class="col-md-12">Điều khoản</label>
                    <div class="col-md-12">
                        <select name="terms" id="terms" value="" class="form-select" aria-label="Default select example" disabled>
                            <option value="{{$copyright->terms}}" selected>{{$copyright->terms}}</option>
                            <option value="Điều khoản tiêu chuẩn">Điều khoản tiêu chuẩn</option>
                            <option value="Điều khoản tùy chỉnh">Điều khoản tùy chỉnh</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3" id="inputLicense">
                    <label class="col-md-12">Giấy phép</label>
                    <div class="col-md-12">
                        <input type="file" name="license_file" id="license_file" value="{{$copyright->license_file}}" class="form-control form-control-line" accept="file/*" disabled>
                        <input type="text" name="text" id="text" hidden disabled>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-3" >
                    <div class="col-md-12">
                        <p><strong>Ngày Thêm: </strong>{{$copyright->created_at}}</p>
                        <p><strong>Ngày cập nhật mới nhất: </strong>{{$copyright->updated_at}}</p>

                    </div>
                </div>
            </form>

            <div class="form-group mt-3">
                <div class="col-sm-12">
                    <button class="btn btn-success" onclick="edit(this)">Chỉnh sửa</button>
                    <button class="btn btn-warning" onclick="upfile(this)">Thay đổi file giấy phép</button>
                    <button class="btn btn-warning" onclick="uptext(this)">Chỉnh sửa hợp đồng</button>

                    <button class="btn btn-info" id="btnSubmit">Lưu</button>
                </div>
            </div>
            <div class="col-sm-8 mx-auto mt-3">
                <iframe src="{{$copyright->license_file}}" id="pdfViewer" class="d-none " width="100%" height="800" type="application/*"></iframe>
            </div>
            <div id="chu_ky" class="row justify-content-center d-none my-4">
                <div class="benA col-md-5">
                    <p>Chữ ký của <strong>Người đại diện A</strong></p>
                    <canvas id="signaturePadA" width="500" height="200" style="border:1px solid #000; color:brown;"></canvas>
                    <br>
                    <button id="clearButtonA">Xóa chữ ký</button>
                    <button id="saveButtonA">Lưu chữ ký</button>
                </div>
                <div class="benB col-md-5">
                    <p>Chữ ký của <strong>Người đại diện B</strong></p>
                    <canvas id="signaturePadB" width="500" height="200" style="border:1px solid #000; color:brown;"></canvas>
                    <br>
                    <button id="clearButtonB">Xóa chữ ký</button>
                    <button id="saveButtonB">Lưu chữ ký</button>
                </div>
            </div>
            <!-- Hợp đồng -->
            <div id="contract-container" class="contract-container d-none">
                <div>
                    <style>
                        .contract-container {
                            font-family: 'DejaVu Sans', sans-serif;
                            margin: 0 auto;
                            width: 210mm;
                            box-sizing: border-box;
                            border: 1px solid black;
                            padding: 94px 76px 94px 113px;

                        }

                        @page {
                            margin-top: 25mm;
                            margin-left: 30mm;
                            margin-right: 20mm;
                            margin-bottom: 25mm;
                        }

                        .contract-container p {
                            font-size: 12pt !important;
                        }

                        h1 {
                            font-size: 16pt !important;
                            text-align: center;
                        }

                        h2 {
                            font-size: 14pt !important;
                            text-align: center;
                        }

                        h3 {
                            font-size: 12pt !important;
                        }

                        ul li {
                            font-size: 11pt !important;
                            font-style: italic;
                        }

                        .button-container {
                            text-align: center;
                            margin-top: 20px;
                        }
                    </style>
                    <h2 style="text-align: center; margin:0;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h2>
                    <h3 style="text-align: center;">Độc lập - Tự do - Hạnh phúc</h3>
                    <p style="text-align:right;"><span class="location_text">............</span>, <span class="issue_day_text">Ngày .. tháng .. năm....</span></p>

                    <h2>HỢP ĐỒNG SỬ DỤNG TÁC PHẨM ÂM NHẠC</h2>

                    <p>Căn cứ vào:</p>
                    <ul>
                        <li>Bộ luật Dân Sự có hiệu lực từ ngày 01 tháng 01 năm 2006 và các văn bản hướng dẫn thi hành.</li>
                        <li>Luật Sở hữu trí tuệ có hiệu lực từ ngày 07 tháng 07 năm 2006 và các văn bản hướng dẫn thi hành.</li>
                        <li>Nghị định 100/NĐ-CP ngày 21/9/2006 của Chính phủ quy định chi tiết và hướng dẫn thi hành một số điều
                            của
                            Bộ luật Dân sự, luật Sở hữu trí tuệ về quyền tác giả và quyền liên quan;</li>
                        <li>Các văn bản pháp luật khác có liên quan.</li>
                        <li>Khả năng và nhu cầu của các Bên.</li>
                        <li>nhu cầu sử dụng của Bên sử dụng tác phẩm âm nhạc.</li>
                    </ul>
                    <p>Hôm nay, vào lúc 10 giờ, <span class="issue_day_text">Ngày ..... tháng ….. năm.........</span>, tại <span class="location_text">............</span>, chúng tôi gồm:</p>
                    <h3>BÊN A : (BÊN CHO PHÉP SỬ DỤNG TÁC PHẨM ÂM NHẠC)</h3>
                    <p>Tên tác giả: <span class="composer_text">__________________</span>.</p>
                    <p>Số CMND/CCCD: <span>__________________</span></p>
                    <p>Địa chỉ: <span class="address_text">__________________</span>.</p>
                    <p>Điện thoại: <span class="phone_text">________________</span>.</p>
                    <p>Email: <span class="email_text">__________________</span>.</p>
                    <p>Là chủ sở hữu bản quyền đối với tác phẩm âm nhạc: <span class="name_song_text">__________________</span>.</p>
                    <p><em>(Trường hợp có nhiều chủ sở hữu thì các chủ sở hữu có thỏa thuận cử người đại diện ký hợp đồng)</em></p>
                    <h3>BÊN B : CÔNG TY GIẢI TRÍ SOUNDWAVE (BÊN SỬ DỤNG TÁC PHẨM ÂM NHẠC)</h3>
                    <p>Đại diện là: <span>Nguyễn Văn A.</span></p>
                    <p>Số CMND/CCCD: <span>0510 8700 7438.</span></p>
                    <p>Địa chỉ công ty: <span>164 Nguyễn Thị Thập, Phường Hòa Minh, Quận Liêu Chiểu, TP Đà Nẵng, Việt Nam.</span></p>
                    <p>Số Giấy Chứng nhận ĐKDN/Quyết định thành lập/Giấy phép thành lập: <span>__________________</span></p>
                    <p>Nơi cấp: <span>__________________</span></p>
                    <p>Ngày cấp: <span>__/__/____</span></p>
                    <p>Mã số thuế: <span>__________________</span></p>
                    <p>Điện Thoại: <span>0905 064 052</span></p>
                    <p>Email: <span>soundwavemusic1410@gmail.com</span></p>
                    <h3>HAI BÊN THỎA THUẬN VÀ KÝ HỢP ĐỒNG VỚI CÁC ĐIỀU KHOẢN SAU ĐÂY:</h3>
                    <p><strong>Điều 1:</strong> Bên A đồng ý cho Bên B sử dụng tác phẩm âm nhạc thuộc quyền sở hữu của mình dưới đây:</p>

                    <p><strong>Tên tác phẩm:</strong> <span class="name_song_text">......................................................................................</span>.</p>
                    <p><strong>Họ và tên tác giả:</strong> <span class="composer_text"> ..............................................................................</span>.</p>

                    <p>
                        <em>(Trường hợp có nhiều tác phẩm, nhiều tác giả thì phải ghi đầy đủ tên tác phẩm, tác giả
                            hoặc có thể lập danh mục riêng kèm theo Hợp đồng. Nếu là tác phẩm phái sinh thì phải nêu rõ
                            tên tác giả và tên tác phẩm gốc.)</em>
                    </p>

                    <p><strong>Chủ sở hữu quyền tác giả:</strong> <span class="publisher_name_text"> ........................................................................................</span>.</p>

                    <p><em>(Trường hợp có nhiều chủ sở hữu quyền tác giả thì phải ghi đầy đủ tên chủ sở hữu hoặc
                            có thể lập danh mục riêng kèm theo Hợp đồng)</em></p>
                    <p>Số giấy chứng nhận đăng ký quyền tác giả (<em>nếu có</em>)........ cấp ngày.....tháng...năm....</p>
                    <p><strong>Điều 2:</strong> Bên A có trách nhiệm chuyển bản sao tác phẩm ghi tại Điều 1 Hợp đồng này cho bên B vào thời gian: <span class="issue_day_text">Ngày ..... tháng ….. năm.........</span>, Địa điểm: <span class="location_text">............</span>.</p>
                    <p>(Các bên có thể ấn định thời hạn hoặc thời điểm chuyển bản sao tác phẩm.)</p>

                    <p><strong>Điều 3:</strong> Bên B có quyền sử dụng tác phẩm ghi tại Điều 1 Hợp đồng này để <span class="usage_rights_text">......................</span> trong thời hạn: <span class="expiry_day_text">__________</span>.</p>

                    <p><strong>Điều 4:</strong> Bên B phải tôn trọng các quyền nhân thân và quyền sở hữu trí tuệ. (Các bên có thể thỏa thuận về việc bên A được xem chương trình liên quan trước khi biểu diễn trước công chúng).</p>
                    <p> Mọi trường hợp sửa chữa tác phẩm hoặc sử dụng tác phẩm dưới hình thức khác với thỏa thuận tại Điều 1 Hợp đồng này phải được sự đồng ý bằng văn bản của bên A.</p>

                    <p><strong>Điều 5:</strong> Bên B phải thanh toán tiền bản quyền sử dụng tác phẩm cho bên A theo phương thức sau:</p>
                    <p><em> (Giá chuyển nhượng, hình thức, cách thức thanh toán; thời gian, địa điểm thanh toán...)</em>
                        <span class="price_text">_________</span> VND,
                        <span class="payment_text">_________</span>,
                        <span class="location_text">_________</span>,
                        <span class="pay_day_text">_________</span>.
                    </p>

                    <p><strong>Điều 6:</strong> Bên A không được chuyển quyền sử dụng tác phẩm theo quy định tại Điều 1 Hợp đồng này cho bên thứ ba trong thời gian thực hiện hợp đồng, trừ trường hợp hai bên có thỏa thuận khác.</p>

                    <p><strong>Điều 7:</strong> Các bên có nghĩa vụ thực hiện các cam kết tại Hợp đồng này. Bên vi phạm hợp đồng phải bồi thường toàn bộ thiệt hại cho bên kia.</p>
                    <p><em> (Các bên có thể thỏa thuận về việc bồi thường theo tỷ lệ % trên giá trị hợp đồng hoặc một khoản tiền nhất định).</em></p>

                    <p><strong>Điều 8:</strong> Tất cả những tranh chấp xảy ra trong quá trình thực hiện hợp đồng hoặc liên quan đến nội dung hợp đồng được giải quyết thông qua thỏa thuận trực tiếp giữa hai bên.
                        Nếu thỏa thuận không đạt kết quả, một trong hai bên có thể nộp đơn yêu cầu Trọng tài hoặc khởi kiện tại Tòa án nhân dân có thẩm quyền để giải quyết.</p>
                    <p><em> (Các bên có thể thỏa thuận lựa chọn tòa án hoặc Trọng tài thuộc quốc gia liên quan).</em></p>

                    <p><strong>Điều 9:</strong> Những sửa đổi hoặc bổ sung liên quan đến hợp đồng phải có sự thỏa thuận bằng văn bản của hai bên.</p>
                    <p><strong>Điều 10:</strong> Hợp đồng này có hiệu lực</p>

                    <p><em>(Các bên có thể thoả thuận về thời điểm có hiệu lực của hợp đồng là ngày ký hợp đồng hoặc khoảng thời gian xác định sau ngày ký hợp đồng hoặc một ngày cụ thể)</em></p>

                    <p>Hợp đồng này được lập thành 02 bản có giá trị như nhau, mỗi bên giữ 01 bản.</p>
                    <p><em>(Các bên có thể thoả thuận về ngôn ngữ, số bản của hợp đồng ký kết)</em></p>
                    <p style="text-align: right;"><span class="location_text">............</span>, <span class="issue_day_text">Ngày ..... tháng ….. năm.........</span></p>
                    <!-- Khu vực chữ ký -->
                    <table style="width: 100%; margin-top: 40px;">
                        <tr>
                            <td style="text-align: center; width: 50%;">
                                <strong>ĐẠI DIỆN BÊN A</strong><br>
                                <em>(Ký tên, đóng dấu)</em><br><br>
                                <img id="signatureImageA" style="display:none; margin-top:10px;" width="150px" />
                                <p class="publisher_name_text"></p>

                            </td>
                            <td style="text-align: center; width: 50%;">
                                <strong>ĐẠI DIỆN BÊN B</strong><br>
                                <em>(Ký tên, đóng dấu)</em><br><br>
                                <img id="signatureImageB" style="display:none; margin-top:10px;" width="150px" />
                                <p>Nguyễn Văn A</p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    function edit(ele) {
        $(document).ready(function() {
            const btn = $(ele);
            const form = [
                'song_id',
                'publisher_id',
                'license_type',
                'issue_day',
                'expiry_day',
                'usage_rights',
                'price',
                'payment',
                'location',
                'pay_day',
                'terms',
            ];
            if (btn.text() == 'Chỉnh sửa') {
                $.each(form, function(index, value) {
                    const input = $('#' + value);
                    input.removeAttr('disabled');
                });
                btn.text('Khóa lại');
            } else {
                $.each(form, function(index, value) {
                    const input = $('#' + value);
                    input.attr('disabled', true);
                });
                btn.text('Chỉnh sửa');
            }
        });
    }

    function upfile(ele) {
        $(document).ready(function() {
            const btn = $(ele);
            if (btn.text() == 'Thay đổi file giấy phép') {
                $('#license_file').removeAttr('disabled');
                $('#contract-container').addClass('d-none');
                $('#chu_ky').addClass('d-none');
                $('#text').attr('disabled', true);
                $('#pdfViewer').addClass('d-none');
                btn.text('Khóa lại');
            } else {
                $('#license_file').attr('disabled', true);
                $('#text').attr('disabled', true);
                $('#pdfViewer').removeClass('d-none');
                btn.text('Thay đổi file giấy phép')
            }

        });
    };

    function uptext(ele) {
        $(document).ready(function() {
            const btn = $(ele);
            if (btn.text() == 'Chỉnh sửa hợp đồng') {
                $('#contract-container').removeClass('d-none');
                $('#license_file').attr('disabled', true);
                $('#chu_ky').removeClass('d-none');
                $('#text').attr('disabled', false);
                $('#pdfViewer').addClass('d-none');
                btn.text('Khóa lại');
            } else {
                $('#license_file').attr('disabled', true);
                $('#text').attr('disabled', true);
                $('#pdfViewer').removeClass('d-none');
                btn.text('Chỉnh sửa hợp đồng')

            }
        });
    };
    $(document).ready(function() {
        $('#song_id').select2({
            placeholder: "Tìm kiếm...",
            allowClear: false,
            width: '100%',
            minimumResultsForSearch: 5,
        });

        $('#publisher_id').select2({
            placeholder: "Tìm kiếm...",
            allowClear: false,
            width: '100%',
            minimumResultsForSearch: 5,
        });

        // validate ngày
        validateDay('#issue_day', 'max'); // hàm trong app.js
        validateDay('#expiry_day', 'min');
        validateDay('#pay_day', 'max');

        // chọn giấy phép


        //hiện giấy phép
        $('#license_file').on('change', function(event) {
            // Lấy file người dùng tải lên
            const file = event.target.files[0];

            // Kiểm tra nếu người dùng chọn file và file là PDF
            if (file && file.type === 'application/pdf') {
                const reader = new FileReader();

                // Khi file được đọc xong, gán URL cho thẻ <embed>
                reader.onload = function(e) {
                    // Gán URL từ FileReader vào thuộc tính src của thẻ <embed>
                    $('#pdfViewer').attr('src', e.target.result).removeClass('d-none');
                };

                // Đọc file dưới dạng Data URL
                reader.readAsDataURL(file);
            } else {
                alert('Vui lòng chọn một file PDF.');
            }
        });

        if ($('#pdfViewer').attr('src')) $('#pdfViewer').removeClass('d-none');
        // add vào hợp đồng
        $('#song_id').on('change', function() {
            const nameSong = $(this).find('option:selected').val();
            console.log(nameSong);
            $.ajax({
                url: '/api/bai-hat/' + nameSong,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    console.log(response.song_name);

                    $('.name_song_text').text(response.song_name);
                    $('.composer_text').text(response.composer);
                }
            })
        });
        $('#publisher_id').on('change', function() {
            const publisher = $(this).find('option:selected').val();
            console.log(publisher);
            $.ajax({
                url: '/api/nha-xuat-ban/' + publisher,
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function(response) {
                    console.log(response.publisher_name);

                    $('.publisher_name_text').text(response.publisher_name);
                    $('.address_text').text(response.address);
                    $('.phone_text').text(response.phone);
                    $('.email_text').text(response.email);
                    // $('#genre').text(response.genre);
                }
            })
        });
        $('#license_type').on('change', function() {
            const license_type = $(this).find('option:selected').text();

        });
        let issue_day = null;
        let expiry_day = null;
        $('#issue_day').on('change', function() {
            issue_day = $(this).val();
            if (issue_day) {
                const [year, month, day] = issue_day.split('-');
                const formattedDate = `ngày ${day} tháng ${month} năm ${year}`;
                $('.issue_day_text').text(formattedDate);
                console.log(formattedDate);
                if (issue_day !== null && expiry_day == null) {
                    // const result = calculateDateDifference(issue_day, expiry_day);
                    $('.expiry_day_text').text(`Vô thời hạn vĩnh viễn`);
                    // console.log(result);
                }
            }
        });

        $('#expiry_day').on('change', function() {
            expiry_day = $(this).val();
            if (issue_day !== null && expiry_day !== null) {
                const result = calculateDateDifference(issue_day, expiry_day);
                $('.expiry_day_text').text(`${result.years} năm, ${result.months} tháng, ${result.days} ngày`);
                console.log(result);
            }
        });
        $('#usage_rights').on('change', function() {
            const usage_rights = $(this).val();
            $('.usage_rights_text').text(usage_rights);

        });
        $('#price').on('change', function() {
            const price = $(this).val();
            $('.price_text').text(price);
        });
        $('#payment').on('change', function() {
            const payment = $(this).val();
            $('.payment_text').text(payment);
        });
        $('#location').on('change', function() {
            const location = $(this).val();
            $('.location_text').text(location);
        });
        $('#pay_day').on('change', function() {
            const pay_day = $(this).val();
            if (pay_day) {
                const [year, month, day] = pay_day.split('-');
                const formattedDate = `ngày ${day} tháng ${month} năm ${year}`;
                $('.pay_day_text').text(formattedDate);
                console.log(formattedDate);
            }


        });

        function calculateDateDifference(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            let years = end.getFullYear() - start.getFullYear();
            let months = end.getMonth() - start.getMonth();
            let days = end.getDate() - start.getDate();

            // Điều chỉnh nếu ngày không đủ để tạo thành tháng
            if (days < 0) {
                months -= 1;
                days += new Date(end.getFullYear(), end.getMonth(), 0).getDate();
            }

            // Điều chỉnh nếu tháng không đủ để tạo thành năm
            if (months < 0) {
                years -= 1;
                months += 12;
            }

            return {
                years,
                months,
                days
            };
        }

    });

    // vẽ chữ ký
    $(document).ready(function() {
        const canvas = document.getElementById('signaturePadA');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        ctx.strokeStyle = '#FF5733'; // Màu đường vẽ (màu đỏ cam)
        ctx.lineWidth = 2;
        // Hàm bắt đầu vẽ
        function startDrawing(e) {
            drawing = true;
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        }

        // Hàm vẽ khi di chuyển chuột
        function draw(e) {
            if (!drawing) return;
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
        // Dừng vẽ khi nhả chuột
        function stopDrawing() {
            drawing = false;
        }

        // Sự kiện chuột cho canvas
        $(canvas).on('mousedown', startDrawing);
        $(canvas).on('mousemove', draw);
        $(canvas).on('mouseup', stopDrawing);
        $(canvas).on('mouseleave', stopDrawing);

        // Nút xóa canvas
        $('#clearButtonA').click(function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            $('#signatureImageA').hide(); // Ẩn ảnh đã lưu nếu có
        });

        // Nút lưu chữ ký
        $('#saveButtonA').click(function() {
            const dataURL = canvas.toDataURL(); // Lấy ảnh từ canvas
            $('#signatureImageA').attr('src', dataURL).show(); // Hiển thị ảnh chữ ký đã lưu

        });
    });
    $(document).ready(function() {
        const canvas = document.getElementById('signaturePadB');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        ctx.strokeStyle = '#FF5733'; // Màu đường vẽ (ví dụ: màu đỏ cam)
        ctx.lineWidth = 2;
        // Hàm bắt đầu vẽ
        function startDrawing(e) {
            drawing = true;
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        }

        // Hàm vẽ khi di chuyển chuột
        function draw(e) {
            if (!drawing) return;
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
        // Dừng vẽ khi nhả chuột
        function stopDrawing() {
            drawing = false;
        }

        // Sự kiện chuột cho canvas
        $(canvas).on('mousedown', startDrawing);
        $(canvas).on('mousemove', draw);
        $(canvas).on('mouseup', stopDrawing);
        $(canvas).on('mouseleave', stopDrawing);

        // Nút xóa canvas
        $('#clearButtonB').click(function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            $('#signatureImageB').hide(); // Ẩn ảnh đã lưu nếu có
        });

        // Nút lưu chữ ký
        $('#saveButtonB').click(function() {
            const dataURL = canvas.toDataURL(); // Lấy ảnh từ canvas
            $('#signatureImageB').attr('src', dataURL).show(); // Hiển thị ảnh chữ ký đã lưu

        });
    });

    $('document').ready(function() {

        // Khi người dùng submit form
        $('#btnSubmit').on('click', function() {
            // Lấy nội dung HTML từ phần tử có id="contract-container"

            const form = [
                'song_id',
                'publisher_id',
                'license_type',
                'issue_day',
                'usage_rights',
                'price',
                'payment',
                'location',
                'pay_day',
                'terms',
            ];
            let check = true;
            form.forEach(ele => {
                const e = $('#' + ele);
                e.removeClass('is-invalid');
                e.removeClass('is-valid');
                e.trigger('change');
                if (e.val() == null || e.val() == '' || e.val() == undefined) {
                    if (ele == 'song_id') {
                        $('span[aria-labelledby="select2-song_id-container"]').addClass('form-select border-danger is-invalid');
                    }
                    if (ele == 'publisher_id') {
                        $('span[aria-labelledby="select2-publisher_id-container"]').addClass('form-select border-danger is-invalid');
                    }
                    e.addClass('is-invalid');
                    check = false;
                    console.log(ele)
                } else {
                    if (ele == 'song_id') {
                        $('span[aria-labelledby="select2-song_id-container"]').removeClass('form-select border-danger is-invalid').addClass('form-select border-success is-valid');
                    }
                    if (ele == 'publisher_id') {
                        $('span[aria-labelledby="select2-publisher_id-container"]').removeClass(' form-select border-danger is-invalid').addClass('form-select border-success is-valid');
                    }
                    e.addClass('is-valid');
                }
            });
            var htmlContent = document.getElementById('contract-container').innerHTML;
            $('#text').val(htmlContent);

            if (!$('#license_file').is(':disabled')) {
                const file = $('#license_file');

                file.removeClass('is-valid')
                file.removeClass('is-invalid');
                if (file.val() == null || file.val() == '' || file.val() == undefined) {
                    file.addClass('is-invalid');
                    check = false;
                    console.log('lôi2')
                } else {
                    file.addClass('is-valid');
                }
            }
            if (!$('#text').is(':disabled')) {
                const file = $('#text');
                $('#license_file').removeClass('is-valid')
                $('#license_file').removeClass('is-invalid');
                if (file.val() == null || file.val() == '' || file.val() == undefined) {
                    alert('input hợp đồng trống')
                    check = false;
                    console.log('lôi3')
                }
            }



            if (!check) {
                alert('Vui lòng điền đầy đủ thông tin.');
                return false;
            } else {
                // thực hiện submit
                $('#submit').submit();
            }

        });

    });
</script>
@endsection
