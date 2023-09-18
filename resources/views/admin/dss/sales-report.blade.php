<table class="table align-items-center table-flush" id="basic-datatable">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">FirstName</th>
            <th scope="col">LastName</th>
            <th scope="col">Customer-No</th>
            <th scope="col">Customer-Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">City</th>
			<th scope="col">State</th>
            <th scope="col">Zip</th>
            <th scope="col">PromoCode</th>
            <th scope="col">Area</th>
            <th scope="col">comments</th>
            <th scope="col">Others question 1</th>
            <th scope="col">Others question 2</th>
            <th scope="col">From which vendor do yo usually buy or supplies from?</th>
            <th scope="col">What was the reason for you to purchase your supplies from other supplies?</th>
            <th scope="col">Are you planning to add any new Classrooms in the near future?</th>
            <th scope="col">Are you refurbishing or creating / constructing new ones?</th>
            <th scope="col" >What would be the timeline, this quarter or the next?</th>
            <th sope="col">Do you buy Discount School Supply/Colorations brand items on Amazon?</th>
            <th scope="col">Created at</th>
            <th scope="col">Agent Name</th>
            <th scope="col">Agent HRMSID</th>

        </tr>
    </thead>
    <tbody>
        @foreach($dsses as $row)

            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->first_name}} </td>
                <td>{{$row->last_name}}</td>
                <td>{{$row->customer_no}}</td>
                <td>{{$row->customer_name}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->phone}}</td>
                <td>{{$row->address}}</td>
                <td>{{$row->city}}</td>
				<td>{{$row->state}}</td>
                <td>{{$row->zipcode}}</td>
                <td>{{$row->promo_code}}</td>
                <td>{{$row->area}}</td>
                <td>{{$row->comments}}</td>
                <td>{{$row->others_question_1}}</td>
                <td>{{$row->others_question_2}}</td>
                <td>{{$row->question_1}}</td>
                <td>{{$row->question_2}}</td>
                <td>{{$row->question_3}}</td>
                <td>{{$row->question_3_1}}</td>
                <td>{{$row->question_3_2}}</td>
                <td>{{$row->question_4}}</td>
                <td>{{$row->created_at }}</td>
                <td>{{($row->user) ? $row->user->name:'' }}</td>
                <td>{{($row->user) ? $row->user->HRMSID:'' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
