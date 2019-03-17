ROOT = 'http://pos.io';
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

    $("#nav-quick-search").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        source: engine.ttAdapter(),

        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        name: 'products-list',

        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            empty: [
                '<div class="list-group search-results-dropdown"><div class="list-group-item"><i class="fa fa-exclamation-triangle"></i> No product found</div></div>'
            ],
            header: [
                '<div  class="search-result-container">'
            ],
            suggestion: function (data) {

                var result = '<div class="search-result">';
                        result += '<div class="row">';
                            result += '<div class="col-4">';
                                result += '<img src="'+ROOT+(data.preview == null ? '/storage/images/products/default.png' : '/storage/images/products/'+data.preview)+'" width="100%">';
                            result += '</div>';
                            result += '<div class="col-8">';
                                result += '<h5 class="product-name"><a href="'+ROOT+'/desk/product/'+data.id+'">'+data.name+'</a> </h5>';
                                result += '<small class="grey">in '+data.category.name+'</small><br>';
                                result += '<small>'+(data.description == null ? '<span class="text-danger">no description</span>' : data.description) +'</small>';
                                result += '<div class="row">';
                                    result += '<div class="col-6"> <span class="badge badge-success">&#8358;'+data.selling_price+'</span></div>';
                                    result += '<div class="col-6">Available: <span class="badge badge-secondary">'+(data.stock - data.sale)+'</span>  </div>';
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