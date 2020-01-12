<link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/core.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/components.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/icons.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/pages.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/menu.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/responsive.css" rel="stylesheet" type="text/css" />
<div class="col-lg-12">
    <div class="card-box">
        <h4 class="m-t-0 header-title">Preuve {{ $data['sanction_id'] }} {{ $data['date'] }}</h4>

        <div class="row">
            <div class="portfolioContainer">
                @foreach($data['screens'] as $row)
                    <div class="col-md-6 col-xl-3 col-lg-4 natural personal">
                        <div class="gal-detail thumb">
                            <a href="https://cdn.badblock.fr/upload/{{ $row['file_name'] }}" class="image-popup" title="Screenshot-1">
                                <img src="https://cdn.badblock.fr/upload/{{ $row['file_name'] }}" class="thumb-img" alt="work-thumbnail">
                            </a>
                            <h5>{{ $row['file_name'] }} - {{ $row['date'] }} </h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
