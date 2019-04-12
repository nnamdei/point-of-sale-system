    <div id="variants">
        @if($product->variants->count() > 0)
                @foreach($product->variants as $v)
                    <?php
                        $index = $loop->index;
                        $variant = [
                            'variable' => $v->variable,
                            'values' => $v->values,
                            'stocks' => $v->stocks
                        ];
                    ?>
                    @include('variant.templates.single-variant')
                @endforeach
            @else
                <div class="alert alert-danger">
                    <i class="fa fa-info"></i> <small>No variant created for this variable product yet</small>
                </div>
                <?php
                    $index = 0;
                    $variant = [
                        'variable' => '',
                        'values' => '',
                        'stocks' => ''
                    ];
                    ?>
                     @include('variant.templates.single-variant')
            @endif
    </div><!--variants-->

    <div class="text-right">
        <button class="btn btn-primary" type="button"  id="new-variant"><i class="fa fa-plus-circle"></i></button>
    </div> 