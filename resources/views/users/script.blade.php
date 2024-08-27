@push('scripts')
    <script>
        $(document).ready(function() {
            $('#office_id').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Kantor Cabang',
                ajax: {
                    url: '/api/offices',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>
@endpush
