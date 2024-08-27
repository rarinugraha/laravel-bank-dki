@push('scripts')
    <script>
        document.getElementById('deposit_display').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = formatRupiah(value);
            e.target.value = formattedValue;
            document.getElementById('deposit').value = value;
        });

        function formatRupiah(value) {
            let numberString = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return 'Rp ' + numberString;
        }

        $(document).ready(function() {
            $('#occupation_id').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Pekerjaan',
                ajax: {
                    url: '/api/occupations',
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

            $('#regency_id').attr('disabled', 'disabled');
            $('#district_id').attr('disabled', 'disabled');
            $('#village_id').attr('disabled', 'disabled');

            $('#province_id').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Provinsi',
                ajax: {
                    url: '/api/provinces',
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
            })

            $('#regency_id').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Kabupaten/Kota',
                ajax: {
                    url: function() {
                        return '/api/regencies/' + $('#province_id').val();
                    },
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

            $('#district_id').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Kecamatan',
                ajax: {
                    url: function() {
                        return '/api/districts/' + $('#regency_id').val();
                    },
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

            $('#village_id').select2({
                theme: "bootstrap-5",
                placeholder: 'Pilih Kelurahan',
                ajax: {
                    url: function() {
                        return '/api/villages/' + $('#district_id').val();
                    },
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

            $('#province_id').change(function() {
                var provinceSelected = $(this).val();
                if (provinceSelected) {
                    $('#regency_id').prop('disabled', false);
                } else {
                    $('#regency_id').prop('disabled', true);
                    $('#district_id').prop('disabled', true);
                    $('#village_id').prop('disabled', true);
                }
                $('#regency_id').val(null).trigger('change');
                $('#district_id').val(null).trigger('change');
                $('#village_id').val(null).trigger('change');
            });

            $('#regency_id').change(function() {
                var regencySelected = $(this).val();
                if (regencySelected) {
                    $('#district_id').prop('disabled', false);
                } else {
                    $('#district_id').prop('disabled', true);
                    $('#village_id').prop('disabled', true);
                }
                $('#district_id').val(null).trigger('change');
                $('#village_id').val(null).trigger('change');
            });

            $('#district_id').change(function() {
                var districtSelected = $(this).val();
                if (districtSelected) {
                    $('#village_id').prop('disabled', false);
                } else {
                    $('#village_id').prop('disabled', true);
                }
                $('#village_id').val(null).trigger('change');
            });
        });
    </script>
@endpush
