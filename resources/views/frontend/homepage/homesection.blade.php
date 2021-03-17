@if(count($sections) > 0)
@foreach($sections as $section)
	<?php  

	$items = App\Models\HomepageSectionItem::where('section_id', $section->id)->where('status', 'active');
	//check section type
	if($section->section_type == 'course'){
		$items->with(['course.course_lessons' => function ($query) {
            $query->where('status', '=', 'active'); }]);
	}

	if($section->section_type == 'category'){
		$items->with(['category' => function ($query) {
            $query->where('status', '=', 1); }, 'category.newsByCategory:category_id']);
	}

	//order by
	if($section->display_type == 'random'){
		$items->inRandomOrder();
	}else{
		$items->orderBy('position', 'asc');
	}

	$items = $items->get();
	?>
    @include('frontend.homepage.'.$section->section_type)
@endforeach 
@endif