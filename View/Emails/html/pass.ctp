<h2>Result Detail</h2>

<div>
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
                <td><?= $result['Application']['first_name']; ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?= $result['Application']['last_name']; ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $result['Application']['email']; ?></td>
            </tr>
            <tr>
                <td>Quiz Name</td>
                <td><?= $result['Quiz']['name']; ?></td>
            </tr>
            <tr>
                <td>Time Started</td>
                <td><?= $result['Result']['start_time'] ?></td>
            </tr>
            <tr>
                <td>Total Time Spent (duration)</td>
                <td><?= $duration; ?></td>
            </tr>
            <tr>
                <td>Percentage Obtained</td>
                <td><?= $result['Result']['percentage']; ?></td>
            </tr>
            <tr>
                <td>Score Obtained</td>
                <td><?= $result['Result']['score']; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><?= $result['Result']['status']; ?></td>
            </tr>
        </tbody>
    </table>
</div>