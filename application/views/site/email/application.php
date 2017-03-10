<html>
<body>
<p>New application was sent.</p>
<div style="margin-left: 20px; padding: 20px;">
    <p><strong>Vehicle: </strong> <?php echo $model->vehicleType->name; ?></p>
    <p><strong>Full Name: </strong> <?php echo $model->first_name . ' ' . $model->last_name; ?></p>
    <p><strong>Email: </strong><?php echo $model->email; ?></p>
    <p><strong>Phone: </strong><?php echo $model->phone; ?></p>
    <p><strong>Birth Day: </strong><?php echo date("F j, Y", strtotime($model->year_of_birth . '-' . $model->month_of_birth . '-' . $model->day_of_birth)); ?></p>
    <p><strong>Address: </strong><?php echo $model->address; ?></p>
    <p><strong>Postal Code: </strong><?php echo $model->postal_code; ?></p>
    <p><strong>Province: </strong><?php echo $model->province->name; ?></p>
    <p><strong>City: </strong><?php echo $model->city; ?></p>
    <p><strong>Rent Or Own: </strong><?php echo $model->rent_or_own; ?></p>
    <p><strong>Residence Years: </strong><?php echo $model->residence_years; ?></p>
    <p><strong>Monthly Payment: </strong><?php echo $model->monthly_payment; ?></p>
    <p><strong>Company Name: </strong><?php echo $model->company_name; ?></p>
    <p><strong>Job Title: </strong><?php echo $model->job_title; ?></p>
    <p><strong>Work Phone: </strong><?php echo $model->work_phone; ?></p>
    <p><strong>Monthly Income: </strong><?php echo $model->monthly_income; ?></p>
    <p><strong>Sin Number: </strong><?php echo $model->sin_number; ?></p>
    <p><strong>Years On Job: </strong><?php echo $model->years_on_job; ?></p>
    <p><strong>Months On Job: </strong><?php echo $model->months_on_job; ?></p>
</div>
</body>
</html>
