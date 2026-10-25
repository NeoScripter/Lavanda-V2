<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email from Lavanda</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f4f5;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emo= ji', 'Segoe UI Emoji', 'Segoe UI Symbol';">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5;">
        <tr>
            <td align="center" style="padding:30px 20px;">
                <table role="presentation" width="550" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:4px;overflow:hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#635782;padding:20px 30px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:20px;font-weight:bold;">Lavanda</h1>
                        </td>
                    </tr>
                    <!-- Main Content -->
                    <tr>
                        <td style="padding-inline:40px;padding-bottom:20px;padding-top:30px;">
                            <h2 style="margin:0 0 16px;color:#18181b;font-size:18px;">Hello <?= html_entity_decode($receiver_name) ?></h2>

                            <?= html_entity_decode($html) ?>

                            <?php if (!empty($link) && !empty($link_label)) : ?>
                                <a href="<?= $link ?>" style="display:inline-block;background-color:#635782;color:#ffffff;text-decoration:none;padding:8px 14px;border-radius:4px;font-size:14px;font-weight:medium;"><?= $link_label ?></a>
                            <?php endif; ?>

                            <hr style="margin:30px 0;border:none;border-top:1px solid #e4e4e7;">
                            <p>С теплом, Lavanda Kim</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
