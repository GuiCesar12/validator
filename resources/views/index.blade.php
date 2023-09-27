@extends('main')
@section('content')   
<br>

<form action=""class="form-control" method="post" name="formEpcis" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-12">
            @csrf
            <label for="">Importar XML</label>
            <input type="file" name="epcis" id="epcis" class="form-control">
        </div>
    </div>

<br>

    <button type="submit" class="btn btn-primary" name="save">Save</button>
</form>
<table>
    <tbody>
        <tr>
            <td>Alice</td>
            <td>25</td>
            <td>São Paulo</td>
        </tr>
        <tr>
            <td>Bob</td>
            <td>30</td>
            <td>Rio de Janeiro</td>
        </tr>
        <tr>
            <td>Charlie</td>
            <td>22</td>
            <td>Salvador</td>
        </tr>
        <!-- Adicione mais linhas conforme necessário -->
    </tbody>
</table>




@endsection
@push('links')
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
<script>


$('[name="formEpcis"]').on('submit', function(e){
    try{
        e.preventDefault();
        const formData = new FormData( this);
        // console.log($('[name="formEpcis"]').find('input[type=file]')[0].files[0]);
        // formData.append('file', $('[name="formEpcis"]').find('input[type=file]')[0].files[0]);
        //verifyForm();
        Swal.fire({
            title: 'Do you want to save the EPCIS?',
            // showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Ok',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{route('verifyEpcis')}}',
                    data: formData,
                    method: 'post',
                    assync: false,
                    // cache: false,
                    contentType: false,
                    processData: false,
                    success: function(returned){
                        Swal.fire('Saved!', '', 'success')
                       
                    },
                    error: function(error, jhrx){
                        Swal.fire('Error!',"'"+error.responseText+"'" , 'error')
                        console.log(error, jhrx);
                    }
                });
                
            }
        });
    }catch(e){
        Swal.fire('Error! ' + e, '', 'error')
    }
});



</script>
@endpush