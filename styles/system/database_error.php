<!DOCTYPE html>
<html>
<head>
    <title>Brightery - Database Error</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <style>
        body {
            max-width: 100%;
            max-height: 100%;
            background-color: #eee;
            font-family: Arimo, "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .database-error {
            margin: 20px;
        }

        h1 {
            font-size: 25px;
            position: relative;
        }

        h1 span {
            font-size: 20px;
            font-weight: normal;
            left: 80px;
            position: absolute;
            top: 20px;
            color: #555;
        }

        .database-error-head {
            float: left;
            margin: 20px 0;
        }

        .error-title {
            margin-bottom: 30px;
            float: left;
            position: relative;
            width: 100%;
            clear: both;
        }

        .error-title img {
            position: absolute;
        }

        .error-title span {
            color: #666;
            padding-left: 35px;
            float: left;
            font-size: 14px;
        }

        .database-error-body {
            float: left;
            width: 100%;
        }

        table {
            border-spacing: 0;
            width: 100%;
            font-size: 14px;
        }

        thead {
            background-color: #d9d9d9;

        }

        .first {
            width: 50px;
        }

        th {
            line-height: 30px;
            background-color: #dedede;
            color: #555;
        }

        td, th {
            border: 1px solid #dbdbdb;
            padding-left: 5px;
        }

        td {
            padding: 10px;
            color: #444;
        }

        .odd {
            background-color: #fff;
        }

        .even {
            background-color: #e5e5e5;
        }

        span.body-title {
            color: #555;
            display: block;
            margin: 10px 0;
            font-size: 18px;
        }

        a.go-back {
            display: block;
            text-align: center;
            margin: 20px 0;
            text-decoration: none;
            color: #6786c4;
        }

        a.go-back:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>
<div class="database-error">
    <h1>
        <img
            src="data:image/png;base64,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">
        <span>Database Errors</span>
    </h1>

    <div class="database-error-head">
        <div class="error-title">
            <img
                src="data:image/png;base64,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"/>
                    <span>
                        <?php echo preg_replace('/SQLSTATE([A-Za-z0-9\:\[\]]+) ([0-9\[\]]+)?/', '', $exception->getMessage()); ?><br/>
                        <?php if (isset($last_query)): ?>
                            <b>Query:</b> <?php echo $last_query; ?>
                        <?php endif ?>
                    </span>
        </div>
        <div class="error-title">
            <img
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAGBklEQVR4Xq2WW2wcVxnHf+ec2Vlfd72JHae5CFctSZO4VKWoIoWkaZWWEppWaqXSIu485CV54CJAFeoTULWAAjR94KXwgKAU2gqCVAWlEheBaGLqhKjUSRPsJDVrr3e99uzFe5k5h53Zo2gbO7uJ0m/3r2/mnNF3/mf2+82O4L0hDv7sF3c6rvuQkmqvgQEhxEY6B8aYiwIWAh0c9mu1P3x13xePAYYOIWxWh37+6+9LR32zv7efVCrFqlUpHMdhaHAwLN6+iBDMZbP4vs/8fJ58Pk+hWEAHwbP7v/TEk0DQzoDz3Au/eiWRTO7dessW+vp60VqHi0YCrsqAzZGklFSrVU6eOoW3uHj4wJc/8wjgs0I4QLdy1N7RLdswQLFY6rBgZ1kjhDXfGHtjL9ANFK5koCsIAgaSfUynZ7EFoCHBtYUBaLlz628YJqwNdLUzIDCwdng1Wmum/zdLtVZDSGvAGrmqhQGjDXHXZf264aimG4sBVy7hYKePjZ3g1tEt3DA8xFKlSn5hkWqlRqFUxPcD2oXjKPp7+4h3uaQGknR3xSmWS1HNWr0OQAcDgqVyhX8ef5NEX1+jyADJZIL+vh5GRtZhDGDAXEaVQGC/FEtl6r7PTCbDQsN8oVC086KzAWEMUja7t1KpkZnLks0t4CiFUk64wwhJR4U5hhAS36/jBz5BQ/V6EGU/CNA6HNMopcBEtTsYsJjZxsMaQan3SspIFjWaho3EmHDeABJDlC3CAjAdiZKAzuWyR+ZyuWZxq/YhrgrDRc8jl507Auh2BnwpRGC0ZmY2Q71et7ttkS3YRq3XR+fFQoFarRaeB4DfzgD9iYE999y9A0dKTr9zlv+8PcH09DSzmSzFUpFCqRwhag21ispSlVK5FD3A0uk0U1PnOX36HcpLFXbuuIvBoTV7OlHgGDSTUxfYfe/dVCtVMtk5crkFFhc9LlzMg6HZFw3RkEQQaG0f2RoMdPfEI3Ju/MAGhoYG6Yp3MdHYTKVaAXDaGZBNjEqMjZ8k0d/PqgaG27atJeY49PZ2Y/vINpRphRBsU5aKSxGGC57Hxek0nldo9gIAyPYUtDTO0lKFdDVDJjvfgmGYYy0YCothiF8j+5cwjLL9uaxp0ZEChGFZQy2XiGRptecrXmuRliAVGnU1GM41MZTvC4Z2cYd8oUZ6vvDHjhgKIQMCzczMyhiKjhi23g2FUDHqhRxb//EEX6j/9MHtNydjbTFMJBJ7du0KMVQrYdhQ2RZfLq2NxbBMJjPH1PmLnD53gZ7jz7Dh44+yfvvDPPv4TUeBWBsMTQPD8w0Md14RwykpcVoxDJoYhh9xCcMkG0dGkOl/4b5bIXXnQyAkA2/9e+tL+2/91GOHTv0eMMswtG9C14dhaYmaFizmFyi//hQf/PQB8Maj+U33P0Yp9+NXgW6gssK/4fuAodbUiKHGnmfkQztxNwzz6P6jALz8/P2s+/B9HP2WOLT7mfF9QIANaXd2XRiKUCqG8s7Tm/4bG+99GM79EIGJxNkfsHHnAwykBr9y8LObNwFi2RuRNhollUWQa8JQSIXBxTn2HDc9uA9mX4UgR7VuNxpkYeZlbv7k5yl7B18C7gBqlgKMt5D/65kzEwRBgOM4KKVCrYShHWtBUCqQLuLt37E61U1yTQG8MXATeF49VHSMd5zk6jxrNn9k9LVv3P41QFoDVL73nW8fODMx8ZsTJ8Y5cXKcycn/kp+fxyt4xGIurhsqTrwh1yoeb2bH7UIQ4Lz1Ipse2A2zr0CsH2QPf/nJ2VDRcTQ281s2797BqkTiaaALQFgSksBaYPWu+z5x2y3bRu8aGl77USVVb8x1h2z3Y7gMIiHxhctti0f42PYR1oycg3oNkOBoHv/RLgBe/PqfwZeABjfOzIWtTLz+p8P3PH38EUEzlHXUC/QA/TbH7ZzkyhE79d3bXxv93AhIB7QAYeFW2vaAbI4bO240b/5yhjue/HvCwV4ClICyRdO16rQ4QKquYxx7IY3WgBFg2bZHGC4bD+lRAiAuuP5IATfafC2RByYdrj9KwCTwLtcWdaD0f0Hx5MyCjsjeAAAAAElFTkSuQmCC"/>
                    <span>
                        <b>Code:</b> <?php echo $exception->getCode(); ?><br/>
                        <b>File:</b> <?php echo str_replace(ROOT, '', $exception->getFile()); ?><br/>
                        <b>Line:</b> <?php echo $exception->getLine(); ?><br/>
                    </span>
        </div>
    </div>


    <div class="database-error-body">
        <span class="body-title">Call Stack</span>
        <script type="text/javascript">
            $(document).ready(function () {
                $('tr:odd td').addClass('odd');
                $('tr:even td').addClass('even');
            });

        </script>
        <table>
            <thead>
            <tr>
                <th class="first">Class/Function</th>
                <th>File</th>
                <th>Line</th>
                <th>Arguments</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($exception->getTrace() as $item): ?>
                <tr>
                    <td><?php echo isset($item['class']) ? $item['class'] : null; ?><?php echo isset($item['type']) ? $item['type'] : null; ?>
                        <b><?php echo isset($item['function']) ? $item['function'] : null; ?></b></td>
                    <td><?php echo isset($item['file']) ? str_replace(ROOT, '', $item['file']) : null; ?></td>
                    <td><?php echo isset($item['line']) ? $item['line'] : null; ?></td>
                    <td>
                        <pre><?php if ($item['args']) print_r($item['args']) ?></pre>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <a href="https://www.brightery.com" class="go-back">Brightery</a>
    </div>
</div>
</body>
</html>
