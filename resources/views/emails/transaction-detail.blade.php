<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
	<tbody>
		<tr>
			<td>
			<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
				<tbody>
					<tr>
						<td style="text-align:center"><a href="#" target="_blank"><img alt="logo" src="https://www.payzz.com/public/backend/images/logo.png" style="width:150px" /> </a></td>
					</tr>
					<tr>
						<td>
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="width:95%">
							<tbody>
								<tr>
									<td>
									<p>Hi {{$FIRST_NAME}} {{$LAST_NAME}},</p>

									<p>Please see below transaction detail.</p>

									<table border="1" cellpadding="1" cellspacing="1">
										<tbody>
											<tr>
												<td>Amount</td>
												<td>Currency</td>
												<td>Payment Method</td>
												<td>Payment Name</td>
											</tr>
											<tr>
												<td>{{$FROM_AMOUNT}}</td>
												<td>{{$FROM_CURRENCY}}</td>
												<td>{{$PAYMENT_METHOD}}</td>
												<td>{{$PAYMENT_NAME}}</td>
											</tr>
										</tbody>
									</table>

									<p>Please <a href="{{$TRANSACTION_DETAIL}}"><em>&nbsp;</em><strong>click here</strong><em>&nbsp;</em></a> to see the complete transaction detail.</p>
									</td>
								</tr>
								<tr>
									<td style="height:40px">&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td style="height:20px">&nbsp;</td>
					</tr>
					<tr>
						<td style="text-align:center">
						<p>&copy; <strong>www.appointment-booking.com</strong></p>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
<!--/100% body table-->
