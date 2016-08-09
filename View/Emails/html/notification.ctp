<h2>Application Detail for <?= $data['Job']['title']; ?> Position</h2>

<div>
    <p>View Details: 
        <?= "<a href='https://www.travelfusion.com/corporate/admin/recruitment/applications/view/{$data['Application']['id']}'>"
        . "https://www.travelfusion.com/corporate/admin/recruitment/applications/view/{$data['Application']['id']}</a>"; 
        ?>
    </p>
    <table>
        <thead>
            <tr>
                <th>Tile</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>First Name</td>
                <td><?= $data['Application']['first_name']; ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?= $data['Application']['last_name']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $data['Application']['email']; ?></td>
            </tr>
            <tr>
                <td>Street Name</td>
                <td><?= $data['Application']['street_name']; ?></td>
            </tr>
            <tr>
                <td>City</td>
                <td><?= $data['Application']['city'] ?></td>
            </tr>
            <tr>
                <td>Post Code</td>
                <td><?= $data['Application']['post_code']; ?></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><?= $data['Application']['country']; ?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><?= $data['Application']['phone']; ?></td>
            </tr>
            <tr>
                <td>Additional Info</td>
                <td><?= $data['Application']['additional_info']; ?></td>
            </tr>
        </tbody>
    </table>
</div>