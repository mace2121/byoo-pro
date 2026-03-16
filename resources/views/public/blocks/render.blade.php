@switch($block->type)
    @case('product')
        @include('public.blocks.product', ['block' => $block, 'design' => $design])
        @break

    @case('link')
    @default
        @include('public.blocks.link', ['block' => $block, 'design' => $design])
@endswitch
