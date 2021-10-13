<x-app-layout>
    <!-- Row -->
    <div class="row">

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-business-center"></i> My Job Listings</h3>
                </div>

                <div class="content">
                    <ul class="dashboard-box-list">
                        @foreach ($projects as $project)
                        <li>
                            <!-- Job Listing -->
                            <div class="job-listing">

                                <!-- Job Listing Details -->
                                <div class="job-listing-details">

                                    <!-- Details -->
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title"><a href="#">{{ $project->title }}</a> <span class="dashboard-status-button yellow">{{ $project->status }}</span></h3>

                                        <!-- Job Listing Footer -->
                                        <div class="job-listing-footer">
                                            <ul>
                                                <li><i class="icon-material-outline-date-range"></i> Posted on {{ $project->created_at }}</li>
                                                <li><i class="icon-material-outline-date-range"></i> Expiring on 28 July, 2018</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="buttons-to-right always-visible">
                                <a href="dashboard-manage-candidates.html" class="button ripple-effect"><i class="icon-material-outline-supervisor-account"></i> Manage Candidates <span class="button-info">3</span></a>
                                <a href="{{ route('client.projects.edit', $project->id) }}" class="button gray ripple-effect ico" title="Edit" data-tippy-placement="top"><i class="icon-feather-edit"></i></a>
                                <a href="#" class="button gray ripple-effect ico" title="Remove" data-tippy-placement="top"><i class="icon-feather-trash-2"></i></a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <!-- Row / End -->
</x-app-layout>