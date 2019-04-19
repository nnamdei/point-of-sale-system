<!-- Scripts -->
<script src="{{ asset('js/vendors/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('js/vendors/typeahead.min.js') }}"></script>
<!-- <script src="{{ asset('js/quick-search.js') }}"></script> -->
<script src="{{ asset('js/scripts.js') }}"></script>
<script>
    ROOT = "{{url('/')}}";
    jQuery(document).ready(function($) {
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/find?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $(".product-quick-search").typeahead({
            hint: true,
            highlight: true,
            minLength: 1,
        }, {
            source: engine.ttAdapter(),
            limit: {{$_product::all()->count()}},
            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'products-list',

            // the key from the array we want to display (name,id,email,etc...)
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item"><i class="fa fa-exclamation-triangle"></i> No product found</div></div>'
                ],
                pending: '<div class="list-group-item search-results-dropdown text-center">Hold on, searching...<div class="py-3 text-center"><img src="{{asset('storage/assets/loading.gif')}}" height="70px"></div></div>',
                header: [
                    '<div  class="search-result-container"><strong><i class="fa fa-search"></i> Results Found...</strong></div>'
                ],
                suggestion: function (data) {

                    var result = '<div class="search-result">';
                            result += '<div class="row align-items-center">';
                                result += '<div class="col-4">';
                                    result += '<img class="product-preview" src="'+ROOT+(data.preview == null ? '/storage/images/products/default.png' : '/storage/images/products/'+data.preview)+'" width="80px" height="80px">';
                                    result += data.barcode != null ? '<div class="text-center text-muted"><small>'+data.barcode.serial+'<small></div>': '';
                                result += '</div>';
                                result += '<div class="col-8">';
                                    result += '<strong class="product-name"><a href="{{route('products.index')}}/'+data.id+'">'+data.name+'</a> </strong>';
                                    result += '<small class="text-muted">in '+data.category.name+'</small><br>';
                                    result += data.description != null ? '<small>'+data.description+'</small>' : '';
                                    result += '<div class="row">';
                                        result += '<div class="col-6"> <span class="badge badge-success">&#8358;'+data.selling_price+'</span></div>';
                                        result += '<div class="col-6">Available: <span class="badge theme-bg">'+(data.stock - data.sale)+'</span>  </div>';
                                    result += '</div>';
                                result += '</div>';
                            result += '</div>';
                    result += '</div>';

                    return result;
        }
            }
        }).bind('typeahead:select', function(ev, suggestion) {
            $(this).typeahead('val',suggestion.name)
        }); 



    }); 


</script>

<!-- Extra script that should live in the head -->
@yield('h-scripts')