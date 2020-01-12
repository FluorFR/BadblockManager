<div class="col-xl-3 col-md-6">
    <div class="card-box">
        <h4 class="header-title mt-0 m-b-30">Cluster : {{ $Cluster['name'] }}</h4>

        <p class="font-600 m-b-5">Cpu <span class="text-primary pull-right">{{ round($Cluster['data']->status->currentCpu * 100, 2) }}%</span></p>
        <div class="progress progress-bar-danger-alt progress-sm m-b-20">
            <div class="progress-bar progress-bar-danger progress-animated wow animated animated" role="progressbar"
                 aria-valuenow="{{ round($Cluster['data']->status->currentCpu * 100, 2) }}" aria-valuemin="0" aria-valuemax="100"
                 style="width: {{ round($Cluster['data']->status->currentCpu * 100, 2) }}%; visibility: visible; animation-name: animationProgress;">
            </div>
        </div>
        <p class="font-600 m-b-5">Ram <span class="text-primary pull-right">{{ round(($Cluster['data']->status->totalMemory - $Cluster['data']->status->freeMemory) / $Cluster['data']->status->totalMemory * 100, 2) }}%</span></p>
        <div class="progress progress-bar-primary-alt progress-sm m-b-20">
            <div class="progress-bar progress-bar-primary progress-animated wow animated animated"
                 role="progressbar" aria-valuenow="{{ round(($Cluster['data']->status->totalMemory - $Cluster['data']->status->freeMemory) / $Cluster['data']->status->totalMemory * 100, 2) }}" aria-valuemin="0" aria-valuemax="100"
                 style="width: {{ round(($Cluster['data']->status->totalMemory - $Cluster['data']->status->freeMemory) / $Cluster['data']->status->totalMemory * 100, 2) }}%; visibility: visible; animation-name: animationProgress;">
            </div>
        </div>
        <center>
            <a href="/" class="btn btn-icon btn-warning"> <i class="fa fa-wrench"></i> </a>
        </center>
    </div>
</div>