    <div class="variants">
        @if(old('variable'))
            <?php 
                $variant = [
                    'variable' => old('variable'),
                    'values' => old('values'),
                    'stocks' => old('v_stocks')
                ];
                ?>
                @include('variant.templates.single-variant')
            <?php  ?>
        @else
            <?php
            $variant = [
                'variable' => '',
                'values' => '',
                'stocks' => ''
            ];
            ?>
            @include('variant.templates.single-variant')
        @endif
    </div><!--variants-->

    <!-- <div class="text-right text-success" style="font-size: 30px">
        <i class="fa fa-plus-circle" onclick="javascript: duplicate('.single-variant', '.variants')" data-toggle="tooltip" title="add another" style="cursor: pointer"></i>
    </div>  -->