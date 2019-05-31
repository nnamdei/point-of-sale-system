<link href="{{ asset('css/vendors/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendors/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendors/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/vendors/normalize.css') }}" rel="stylesheet">
<link href="{{ asset('css/layouts.css') }}" rel="stylesheet">
<style>

    body{
        background: url('{{asset("storage/assets/bg-lines.jpg")}}');
        background-attachment: fixed;
        min-height: 100vh;
        font-size: 13px;   
    }
    /* .barcode-scanner[data-status='enabled'] form{
        display: block;
    }   
    .barcode-scanner[data-status='disabled'] form{
        display: none;
    } */
    .scanner-img{
        filter: grayscale(100%);
        opacity: 0.2;
    }
    .scanner-img[active]{
        opacity: 1;
    }
    .scanner-receptor{
        width: 30px;
        height: 30px;
        text-indent: -100px;
        border-radius: 50%;
        background-color: #f7f7f7;
    }
    .scanner-receptor[active]{
        background-color: #ff1111;
    }
    nav{
        background-color: #fff;
        box-shadow: 0px 5px 5px rgba(0,0,0,.2);
    }
    nav a.nav-link{
        color: #000
    }

    a,
    a:hover,
    .theme-color,
    .lhs-fixed .card-header,
    #insights-container .ngn
    {
        color : {{themeColor()}}
    }
    .white{
        color: #fff;
    }
    .grey{
        color: grey;
    }
    a:hover{
        opacity: .9;
        text-decoration: none;
    }
    a.theme-btn:hover{
        color: #fff;
    }

    .theme-bg,
    a[role='tab'],
    .theme-btn,
    .btn-outline-secondary:hover
    {
    background-color:  {{themeColor()}};
    color: #fff;
    }
    .theme-gradient-bg{
    background: linear-gradient({{themeColor()}},#f7f7f7);
    }
    .btn-outline-secondary:hover
    {
        border: none;
    }
    a,.btn{
        transition: all .4s ease-in-out;
    }
    a[role='tab']{
        color: #fff;
        margin-left: 5px;
        margin-right: 5px;
    }
    a[role='tab']:hover{
        color: #fff;
    }

    .card{
        border: 0;
    }
    .card-header,
    .card-body
    {
        background-color: #fff;
    }
    .card-body{
        overflow: auto;
    }
    .no-radius{
        border-radius: 0 !important;
    }
    .dropdown-menu,
    .collapse:not(.navbar-collapse)
    {
        box-shadow: 0px 10px 10px rgba(0,0,0,.2)
    }
.avatar,
.product-preview{
    border-radius: 50%;
    border: 1px solid {{themeColor()}};
}

#insights-container .ngn{
    font-size: 30px;
    font-weight: bolder;
    /* color: rgba(52, 200, 64, 1);; */
}  
.card{
    margin-bottom: 5px;
}
#insights-container .card-body{
    overflow: hidden;
}
#insights-container .card-body:hover{
    overflow: auto;
}


/* Typeahead suggestions container */
.tt-menu{
    background-color: #fff;
    color: #343a40;
    border-radius: 3px;
    max-height: 70vh;
    overflow: auto;
    box-shadow: 0px 30px 30px rgba(0, 0, 0, .2);

}
.tt-menu.tt-open{
    left: -50px !important;
    width: 300px;
}
.tt-dataset-products-list{
  
}
.search-result-container{

}
.search-result{
    border-bottom: 1px solid #f7f7f7;
    padding: 10px 0px;
}
.search-result:nth-child(even){
    background-color: #fff;
}
.search-result:nth-child(odd){
    background-color: #f7f7f7;
}
.product-name{
    margin-bottom: 2px;
}

.product-type{
    margin: 8px;
    padding: 8px;
    background-color: #f7f7f7;
    border: 1px solid #eee;
    border-radius: 3px;
}
.operations{
    margin: 0 5px;
}
.variable-values{
    letter-spacing: 2px;
    text-decoration: underline;
}
#variants-container{
    background-color: #eee;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0,0,0,.6);
    margin-bottom:1rem;
}
.single-variant{
    padding: 5px;
}
.single-variant:nth-child(1) .remover-container{
    display: none;
}
.single-variant:nth-child(1) .remover-container .single-variant-remover{
   cursor: pointer;
}
.single-variant:nth-child(odd){
    background-color: #f7f7f7;
}
.single-variant:nth-child(even){
    background-color: #fff;
}
.has-error{
    color: #ff0000;
}
.no-padding{
    padding: 0 !important;
}

.has-operations .operations-container{
    display: none;
}
.has-operations:hover .operations-container{
    display: block;
}


.stock-update-forms-container .inputs-container{
    max-height: 60vh;
    overflow-y: hidden;
}
.stock-update-forms-container .inputs-container:hover{
    overflow-y: auto;
}

/*Products table*/
.products-table-container
{
    width: 956px;
}
.products-table-body-container{
    max-height: 65vh;
    overflow:hidden;
}
.products-table-body-container:hover{
    overflow-y: auto;
}

.products-table-container table tr .id>div
{
   width:30px;
}
.products-table-container table tr .product>div
{
  width: 100px;
}
.products-table-container table tr .category>div
{
    width: 60px
}

.products-table-container table tr .type>div
{
    width: 50px;
}

.products-table-container table tr .stock>div
{
    width: 400px;
}
.products-table-container table tr .base-price>div
{
    width: 70px
}
.products-table-container table tr .selling-price>div
{
    width: 70px
}
.products-table-container table th>div,
.products-table-container table td>div
{
   /* overflow: auto;*/
}

.products-table-container th,
.products-table-container td{
    padding-left: 12px !important;
    padding-right: 12px !important;
}
table.products-table-head tr:first-child th{
    border: 0;
} 
.products-table-body .product-row .hidden{
    display: none;
}
.products-table-body .product-row:hover .hidden{
    display: block;
}

.product-grid{
    width: 100%;
    height: 200px;
    border-radius: 3px;
    box-shadow: 0px 5px 5px rgba(0,0,0,.2)
}
.product-grid .hidden-info{
    display: none;
    max-height: 120px;
    overflow: auto;
    transition: all .3s easeinout; 
}
.product-grid:hover .hidden-info{
    display: block;
}
.grid-details-container{
    position: absolute;
    bottom: 4px;
    left: 4px;
    right: 4px;
    background-color: rgba(255,255,255,.9);
    border-radius: 0px 0px 3px 3px;
}
.grid-details-container .price{
    background-color:{{themeColor()}};
    color: #fff;
}

.grid-cart{
    position: absolute;
    right: 3px;
    top: 0;
    background-color: #fff;
    border-radius: 3px 3px 3px 3px;
}


@media (max-width: 576px){
    nav .product-quick-search{
        width: 150px !important
    }     
}
@media (min-width: 576px){

}
@media (min-width: 768px){

}
@media (min-width: 992px){
    .tt-menu.tt-open{
        left: 0px !important;
        width: 400px;

    }
}
</style>
@yield('styles')
