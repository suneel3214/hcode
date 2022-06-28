<div class="table-responsive" id="productUpdateList">
            <div class="table_fields">
                <div class="">
                    <select name="productList_length" aria-controls="productList" class="productStausDrop">
                        <option value="">-- Select Status --</option>
                        <option value="inreview">Inreview</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div id="productList_filter" class="dataTables_filter">
                    <input type="search" class="searchField" placeholder="Search Product by Name" aria-controls="productList">
                </div>
                <div>
                    <a class="btn btn-primary fa fa-search ml-1 search" rel='' style="color:#fff;"></a>
                </div>
              </div>    
            @if(count($products) > 0)        
                <table class="table" id="productList1">
                    <thead>
                        <tr>                        
                            <th scope="col">#</th>
                            <th style="width: 257px;" scope="col">Product Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Remaning Day</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Reviews</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php $count = 1; ?>
                                @foreach($products as $product )
                                    
                                    <?php 
                                        $start = strtotime(date('Y-m-d'));
                                        $end = !empty($product->end_date) ? strtotime($product->end_date):strtotime(date('Y-m-d'));
                                    
                                        $days_between = strtotime($product->end_date) >= strtotime(date('Y-m-d')) ?  !empty($product->start_date) ? ceil(abs($end - $start) / 86400) : 0 :0;
                                    ?>
                                    <tr>
                                        <th>{{$count++}}</th>
                                        <th scope="row" class="notText"><a href="https://hithere.co.nz/product/{{$product->pro_id}}">{{$product->name}}</a></th>
                                        <th scope="row">{{date('d M y',strtotime($product->start_date))}}</th>
                                        <th scope="row">{{date('d M y',strtotime($product->end_date))}}</th>
                                        <th scope="row" title="{{$days_between <=2 ? 'Your product will be inactive after '.$days_between.' days':''}}">
                                            {{$days_between}} Days 
                                            @if($days_between <= 2 || $days_between === 0)
                                                    <a class=" btn-sm text-warning text-white addMoreDays" data-id ={{$product->pro_id}}>
                                                    <i class="nav-icon font-weight-bold i-Add text-danger" title="You can add 14 days"></i>
                                              </a>
                                            @endif    
                                        </th>
                                        <td>{{$product->free_option ?  'Free' : $product->price}}</td>
                                        <td>{{$product->qty}}</td>
                                        <td>{{$product->product_review_count}} 
                                            @if($product->product_review_count  > 0)
                                                <a href="#" url="{{route('getReviews',$product->pro_id)}}" class="sowReviews">
                                                    <i class="nav-icon i-Eye-Scan font-weight-bold"></i>
                                                </a>
                                            @endif  
                                          </td>
                                        <td>
                                                @if($product->status === 'active')
                                                    <span style="background-color: #6420ff;color:#fff" class="badge">Active</span>
                                                @elseif($product->status === 'inactive')
                                                    <span  class="badge badge-warning" style="background-color:#898983;color:#fff"> Inactive    </span>
                                                @elseif($product->status === 'rejected')
                                                    <span  class="badge badge-danger"> Rejected </span>
                                                @elseif($product->status === 'inreview')
                                                    <span  class="badge badge-warning"> Inreview    </span>         
                                                @endif  
                                               
                                        </td>
                                        <td>  
                                            
                                        <div class="btn-group">
                                              <button style="border-color:#6420ff;background-color:#6420ff;" type="button" class="ml-1 btn  btn-sm btn-danger dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                              </button>
                                              <div class="dropdown-menu">
                                                    @if($product->status !== 'inreview')    
                                                        <a class="dropdown-item approval" data-id="{{$product->pro_id}}" type="active" href="javascript:void(0)">Active</a>
                                                        <a class="dropdown-item approval" data-id="{{$product->pro_id}}" type="inactive" href="javascript:void(0)">Inactive</a>
                                                    @endif          

                                                    @role('super_admin')
                                                        <a class="dropdown-item approval" data-id="{{$product->pro_id}}" type="active" href="javascript:void(0)">Active</a>
                                                        <a class="dropdown-item approval" data-id="{{$product->pro_id}}" type="inactive" href="javascript:void(0)">Inactive</a>
                                                        <a class="dropdown-item approval" data-id="{{$product->pro_id}}" type="active" href="javascript:void(0)">Approved</a>
                                                        <a class="dropdown-item approval" data-id="{{$product->pro_id}}" type="rejected" href="javascript:void(0)">Disapproved</a>
                                                    @endrole                                                                                    
                                              </div>
                                        </div> 
                                            {{-- <a class="text-success mr-2" href="{{route('products.show',$product->pro_id)}}">
                                                <i class="nav-icon i-Eye-Scan font-weight-bold"></i>
                                            </a> --}}
                                            <a class="text-warning mr-2" href="{{route('products.edit',$product->pro_id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                            </a>
                                          {{--   <a class="text-danger mr-2" href="{{route('product_destroy',$product->pro_id)}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a> --}}
                                          </td>
                                    </tr>
                                @endforeach
                      </tbody>   
                </table>
                @else
                    <table class="table" id="productList1">
                        <thead>
                            <tr>                        
                                <th scope="col">#</th>
                                <th style="width: 257px;" scope="col">Product Name</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Remaning Day</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Reviews</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                            <tbody>

                            </tbody>
                    </table>
                    <div style="text-align: center;">
                        No record found
                    </div>      
                      @endif     
        </div>
        <div id="paginationLink">
            {{ $products->links() }}
        </div>