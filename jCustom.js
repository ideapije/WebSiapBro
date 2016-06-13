$(document).ready(function () {
    var urlJsonP = $('span.url_act').text()+'/GetJsonMyDonasi';
    $('table.donasi-program-table').DataTable({
      "oLanguage": {
          "sEmptyTable":     "Belum ada data. <a href='#' class='btn btn-primary add-from-tb'><i class='glyphicon glyphicon-plus'></i> Tambahkan data</a>"
        },
        "iDisplayLength": 5,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": urlJsonP,
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        }
        ]
    });
	$('input[name="donatur_nama"]').focus();
    $("input[name=filektp]").change(function () {
        readURL(this);
    });
    $(document).on('click','.btn-donate',function(){
        //alert('wew');
        var id = $(this).attr('id');
        $('input.jml-'+id).css('display','block');
        $(this).addClass('btn-donate-submit');
        $(this).text('submit');
    });

    $(document).on('click','a.item-upload',function(){
        var id      = $(this).attr('id');
        var judul   = $('h4.heading-'+id).text();
        var urlJson = $('span.url_act').text()+'/RequestGetSrcDokumen';
        var baseurl = $('span.base-url-upload').text();
        var kirim   = {'dokid':id};
        if ($('p.uid').length == 1) {
            kirim['uid'] = $('p.uid').text();
        };
        $.ajax({
            url: urlJson,
            data: kirim,
            type:"POST",
            dataType:"json",
            success: function(data){        
                
                if (data.length > 0) {
                    $.each( data, function( key, val ) {
                        if (val.sb_dok_src == null) {
                            $('form.upload-submit').after('mohon maaf anda harus upload ulang, karena dokumen <b>'+judul+'</b> tidak ditemukan dalam server');
                        }else{
                            $('div.modal-body').html('<img src="'+baseurl+val.sb_dok_src+'" class="img-responsive" alt="'+judul+'"/>');    
                            if (val.sb_verify == 1) {
                                $('.modal-footer').html('<span style="font-size:14px;" class="label label-success">sudah terverifikasi</span>');
                            };
                        }
                        
                    });
                }
                $('h4.modal-title').text(judul);
                $('input[name="sb_dok_id"]').val(id);
                $('#modalupload').modal('show');
            }
        });
    });
//urladmAct
    

    $(document).on('click','a.btn-donate-submit',function(){
        var id      = $(this).attr('id');
        var jml     = $('input.jml-'+id).val().trim();
        var url_act = $('span.url_act').text()+'/DonateSubmit';
        if (jml.length > 0) {
            $.ajax({
            url: url_act,
            type:"POST",
            data: {'donasi_program_id':id,'donasi_jumlah':jml},
                success :function(data){
                    if (data == '0') {
                        alert('gagal memberi donasi');
                    }
                    location.reload();
                }
            });
        }else{
            alert('angka tidak boleh kosong');
            location.reload();
        }
        
    });
    
});
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
}
