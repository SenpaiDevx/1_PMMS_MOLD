import '../../node_modules/jquery/dist/jquery.min.js'
import '../../node_modules/tabulator-tables/dist/js/tabulator.min.js'
import '../../node_modules/select2/dist/js/select2.full.min.js'
import '../../node_modules/htmx.org/dist/htmx.min.js'
import '../../public/js/j_ui/jquery-ui.min.js'
class QRCODE_PLAN {
    constructor() {

    }

    $QR_1(data) {
        console.log(data)

        $.ajax({
            url: '/1_PMMS_MOLD/db_php/qrcode/render_list.php',
            method: 'POST',
            data: {
                'pms': data['PMS_CONTROL_NO']
            }, success: ($row) => {
                const table_rows = JSON.parse($row);
                const pms_issued = data['PMS_ISSUED'].split(' ');
                console.log(table_rows)
                const $rows = () => {
                    let count_row = []
                    for (let index = 0; index < 10; index++) {
                        count_row.push([index, '', '', '', '', '', '', '', '', '', '', ''])
                        continue;
                    }
                    return count_row
                }

                console.log($rows())
                var qr_pdf = {
                    pageSize: 'A4',
                    content: [ //[left, top, right, bottom]
                        {
                            margin: [-25, -33, 0, 0],
                            qr: data['PMS_CONTROL_NO'],
                            fit: 60

                        }, {
                            margin: [29, -43, 0, 0],
                            table: {
                                headerRows: 1,      //
                                widths: [35, 30, 50, 60, 70, 70, 65, 60],
                                body: [
                                    [{
                                        margin: [0, 10],
                                        text: "P1 Issue",
                                        alignment: 'center',
                                        bold: true,
                                        rowSpan: 4,
                                        fontSize : 10
                                    }, { text: 'No.', bold: true, fontSize: 8 }, { text: data['PMS_JOB_NO'], fontSize: 8 }, { text: `${data['TYPE']} MOLD_WORK SHEETS`, colSpan: 3, rowSpan: 4, alignment: 'center', bold: true, fontSize: 14, margin: [0, 12] }, ' ', '', { text: 'Process Design', bold: true, fontSize : 9 }, { text: 'M-A/SV-Leader', alignment: "center", fontSize : 8 }],
                                    [' ', { text: 'Date', bold: true, fontSize: 8 }, { text: pms_issued[0], fontSize: 8 }, { text: ' ', colSpan: 4, fontSize : 8 }, ' ', ' ', { text: 'Planned by', bold: true, fontSize : 9 },{ text: 'Process Planner', alignment: "center", fontSize : 8 }],
                                    [' ',
                                        { text: 'Time', rowSpan: 2, bold: true, fontSize : 8},
                                        { text: pms_issued[1], rowSpan: 2, bold: true, fontSize : 8},
                                        '',
                                        '',
                                        '',
                                        { text: 'Confirmed by', bold: true, fontSize : 9, rowSpan : 2 },
                                        { text: 'Manager - GM', fontSize : 9, rowSpan : 2 },
                                    ],
                                    ['', '', '', '', '', '', '','']
                                ]
                            }
                        }, {
                            margin: [-26, 5, 0, 0],
                            table: {
                                widths: [25, 65, 80, 60, 60, 60, 40, 48, 48],
                                body: [
                                    [{ text: 'M/P', alignment: "center", bold: true, fontSize : 10 },
                                    { text: 'TARGET', bold: true, fontSize : 10 },
                                    { text: 'CONTROL NO.', bold: true, fontSize : 10 },
                                    { text: 'CODE', bold: true, fontSize : 10 },
                                    { text: 'Mold Name & Part Name', colSpan: 2, alignment: 'center', bold: true, fontSize : 10 },
                                        ' ',
                                    { text: 'Detials', colSpan: 3, alignment: 'center', bold: true, fontSize : 10 }, ' ', ' '],
                                    [{ text: 'P1', rowSpan: 2, alignment: "center", margin: [0, 10], bold: true, fontSize: 14 }, { text: data['TARGET_DATE'], rowSpan: 2, fontSize: 9, bold: true, margin: [0, 10] }, { text: data['PMS_CONTROL_NO'], rowSpan: 2, fontSize: 9, margin: [0, 10], bold: true }, { text: data['PMS_MOLD_ID'], rowSpan: 1, bold: true, fontSize :9 }, { text: data['MOLD_NAME'], colSpan: 2, bold: true, fontSize :9 }, '', { text: 'Cavity', bold: true, alignment: "center", fontSize :9 }, { text: `Job Q'ty`, bold: true, alignment: "center", fontSize :9 }, { text: 'Charge', bold: true, alignment: "center", fontSize :9 }],
                                    ['', '', '', { text: data['DRAWING_NO'], fontSize: 9 }, { text: data['PART_NAME'], colSpan: 2, fontSize: 9 }, ' ', { text: data['CAVITY'], fontSize: 9 }, { text: data['JOB_QTY'], fontSize: 9 }, { text: data['CHARGE'], fontSize: 9 }],
                                ]
                            }
                        }, {
                            margin: [-26, 0, 0, 0],
                            table: {
                                widths: [20, 55, 57, 25, 30, 40, 40, 50, 43, 45, 20, 34],
                                body: [
                                    [{ text: 'PROCESS PLAN', alignment: 'center', bold: true, colSpan: 5, fontSize : 9}, '', '', '', '', { text: 'Working Time(h:mm)', colSpan: 2, alignment: 'center', bold: true, fontSize : 9 }, '', { text: 'Result', colSpan: 2, alignment: "center", bold: true, fontSize : 9 }, '', { text: 'DEFECT-NG', colSpan: 3, alignment: "center", bold: true, style: { color: 'red' }, fontSize : 9 }, '', ''],
                                    [{ text: 'No', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'Process #', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'O/P Name', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'D/N', alignment: "center", bold: true, fontSize: 9 },
                                    { text: '(min)', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'Start', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'Finish', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'Done/ON', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'OK/NG', alignment: "center", bold: true, fontSize: 9 },
                                    { text: 'Process', alignment: "center", bold: true, fontSize: 9 },
                                    { text: `Q'ty`, alignment: "center", bold: true, fontSize: 9 },
                                    { text: '(min)', alignment: "center", bold: true, fontSize: 9 },
                                    ],
                                    // create a loop here where out is ilke this ['' , '', '', '', '', '', '', '', '', '', '', '']
                                    [{ text: 1, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 2, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 3, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 4, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 5, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 6, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 7, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 8, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 9, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                                    [{ text: 10, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],

                                ]
                            }
                        }, {
                            margin: [-26, 0, 0, 0],
                            table: {
                                widths: [28, 28, 31, 31, 30, 26, 26, 41, 41, 30, 50, 45, 43],
                                body: [
                                    [{ text: 'Material Input by Leader', colSpan: 5, fontSize: 10, alignment: 'center', bold: true }, '', '', '', '', { text: 'Purchase Request by Leader', colSpan: 5, fontSize: 10, alignment: 'center', bold: true }, '', '', '', '', { text: 'Processing', fontSize: 10, alignment: "center", colSpan: 3, bold: true }, '', ''],
                                    [
                                        { text: 'Material', colSpan: 2, fontSize:9, alignment: 'center', bold: true },
                                        '',
                                        { text: 'Spec. (X*Y*Z)', colSpan: 2, fontSize:9, alignment: 'center', bold: true },
                                        '',
                                        { text: `Q'ty`, fontSize:9, alignment: 'center', bold: true },
                                        { text: 'Item', colSpan: 2, fontSize:9, alignment: 'center', bold: true },
                                        '',
                                        { text: 'Specs.', fontSize:9, alignment: 'center', bold: true },
                                        { text: 'Process', fontSize:9, alignment: 'center', bold: true },
                                        { text: `Q'ty`, fontSize:9, alignment: 'center', bold: true },
                                        { text: 'Approve', fontSize:9, alignment: 'center', bold: true },
                                        { text: 'Delivery', fontSize:9, alignment: 'center', bold: true },
                                        { text: 'Encode', fontSize:9, alignment: 'center', bold: true }
                                    ],
                                    [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', '', '', ''],
                                    [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', '', '', ''],
                                    [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', '', '', ''],
                                    [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', { text: 'A/SV-M', fontSize: 9, alignment: 'center' }, { text: 'Planner', fontSize: 9, alignment: 'center' }, { text: 'Staff', fontSize: 9, alignment: 'center' }],
                                ]
                            }
                        }

                    ],
                    styles: {
                        paddedCell: {
                            paddingLeft: 10,
                            paddingRight: 10,
                            paddingTop: 20,
                            paddingBottom: 20
                        },
                        tallCell: {
                            height: 50
                        },

                    }
                }


                const pdfDocGenerator = pdfMake.createPdf(qr_pdf);
                pdfDocGenerator.getBlob((blobs) => {
                    var timelapse = new Date().getTime();
                    // URL.revokeObjectURL(pdfUrl)
                    var pdfUrl = URL.createObjectURL(blobs);
                    PDFObject.embed(pdfUrl, '#qr_embed', { height: '500px', width: '1000px', forcePDFJS: true });
                })
            }
        })


    }

    $QR_2(data) {
        console.log(data)
        const pms_issued = data['PMS_ISSUED'].split(' ');
       

        var qr_pdf1 = {
            pageSize: 'A4',
            content: [ //[left, top, right, bottom]
                {
                    margin: [-25, -33, 0, 0],
                    qr: data['PMS_CONTROL_NO'],
                    fit: 60

                }, {
                    margin: [29, -43, 0, 0],
                    table: {
                        headerRows: 1,      //
                        widths: [35, 30, 50, 60, 70, 70, 65, 60],
                        body: [
                            [{
                                margin: [0, 10],
                                text: "P1 Issue",
                                alignment: 'center',
                                bold: true,
                                rowSpan: 4,
                                fontSize : 10
                            }, { text: 'No.', bold: true, fontSize: 8 }, { text: data['PMS_JOB_NO'], fontSize: 8 }, { text: `${data['TYPE']} MOLD_WORK SHEETS`, colSpan: 3, rowSpan: 4, alignment: 'center', bold: true, fontSize: 14, margin: [0, 12] }, ' ', '', { text: 'Process Design', bold: true, fontSize : 9 }, { text: 'M-A/SV-Leader', alignment: "center", fontSize : 8 }],
                            [' ', { text: 'Date', bold: true, fontSize: 8 }, { text: pms_issued[0], fontSize: 8 }, { text: ' ', colSpan: 4, fontSize : 8 }, ' ', ' ', { text: 'Planned by', bold: true, fontSize : 9 },{ text: 'Process Planner', alignment: "center", fontSize : 8 }],
                            [' ',
                                { text: 'Time', rowSpan: 2, bold: true, fontSize : 8},
                                { text: pms_issued[1], rowSpan: 2, bold: true, fontSize : 8},
                                '',
                                '',
                                '',
                                { text: 'Confirmed by', bold: true, fontSize : 9, rowSpan : 2 },
                                { text: 'Manager - GM', fontSize : 9, rowSpan : 2 },
                            ],
                            ['', '', '', '', '', '', '','']
                        ]
                    }
                }, {
                    margin: [-26, 5, 0, 0],
                    table: {
                        widths: [25, 65, 80, 60, 60, 60, 40, 48, 48],
                        body: [
                            [{ text: 'M/P', alignment: "center", bold: true, fontSize : 10 },
                            { text: 'TARGET', bold: true, fontSize : 10 },
                            { text: 'CONTROL NO.', bold: true, fontSize : 10 },
                            { text: 'CODE', bold: true, fontSize : 10 },
                            { text: 'Mold Name & Part Name', colSpan: 2, alignment: 'center', bold: true, fontSize : 10 },
                                ' ',
                            { text: 'Detials', colSpan: 3, alignment: 'center', bold: true, fontSize : 10 }, ' ', ' '],
                            [{ text: 'P1', rowSpan: 2, alignment: "center", margin: [0, 10], bold: true, fontSize: 14 }, { text: data['TARGET_DATE'], rowSpan: 2, fontSize: 9, bold: true, margin: [0, 10] }, { text: data['PMS_CONTROL_NO'], rowSpan: 2, fontSize: 9, margin: [0, 10], bold: true }, { text: data['PMS_MOLD_ID'], rowSpan: 1, bold: true, fontSize :9 }, { text: data['MOLD_NAME'], colSpan: 2, bold: true, fontSize :9 }, '', { text: 'Cavity', bold: true, alignment: "center", fontSize :9 }, { text: `Job Q'ty`, bold: true, alignment: "center", fontSize :9 }, { text: 'Charge', bold: true, alignment: "center", fontSize :9 }],
                            ['', '', '', { text: data['DRAWING_NO'], fontSize: 9 }, { text: data['PART_NAME'], colSpan: 2, fontSize: 9 }, ' ', { text: data['CAVITY'], fontSize: 9 }, { text: data['JOB_QTY'], fontSize: 9 }, { text: data['CHARGE'], fontSize: 9 }],
                        ]
                    }
                }, {
                    margin: [-26, 0, 0, 0],
                    table: {
                        widths: [20, 55, 57, 25, 30, 40, 40, 50, 43, 45, 20, 34],
                        body: [
                            [{ text: 'PROCESS PLAN', alignment: 'center', bold: true, colSpan: 5, fontSize : 9}, '', '', '', '', { text: 'Working Time(h:mm)', colSpan: 2, alignment: 'center', bold: true, fontSize : 9 }, '', { text: 'Result', colSpan: 2, alignment: "center", bold: true, fontSize : 9 }, '', { text: 'DEFECT-NG', colSpan: 3, alignment: "center", bold: true, style: { color: 'red' }, fontSize : 9 }, '', ''],
                            [{ text: 'No', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'Process #', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'O/P Name', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'D/N', alignment: "center", bold: true, fontSize: 9 },
                            { text: '(min)', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'Start', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'Finish', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'Done/ON', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'OK/NG', alignment: "center", bold: true, fontSize: 9 },
                            { text: 'Process', alignment: "center", bold: true, fontSize: 9 },
                            { text: `Q'ty`, alignment: "center", bold: true, fontSize: 9 },
                            { text: '(min)', alignment: "center", bold: true, fontSize: 9 },
                            ],
                            // create a loop here where out is ilke this ['' , '', '', '', '', '', '', '', '', '', '', '']
                            [{ text: 1, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 2, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 3, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 4, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 5, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 6, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 7, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 8, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 9, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],
                            [{ text: 10, alignment: "center", fontSize : 9 }, '', '', '', '', '', '', '', '', '', '', ''],

                        ]
                    }
                }, {
                    margin: [-26, 0, 0, 0],
                    table: {
                        widths: [28, 28, 31, 31, 30, 26, 26, 41, 41, 30, 50, 45, 43],
                        body: [
                            [{ text: 'Material Input by Leader', colSpan: 5, fontSize: 10, alignment: 'center', bold: true }, '', '', '', '', { text: 'Purchase Request by Leader', colSpan: 5, fontSize: 10, alignment: 'center', bold: true }, '', '', '', '', { text: 'Processing', fontSize: 10, alignment: "center", colSpan: 3, bold: true }, '', ''],
                            [
                                { text: 'Material', colSpan: 2, fontSize:9, alignment: 'center', bold: true },
                                '',
                                { text: 'Spec. (X*Y*Z)', colSpan: 2, fontSize:9, alignment: 'center', bold: true },
                                '',
                                { text: `Q'ty`, fontSize:9, alignment: 'center', bold: true },
                                { text: 'Item', colSpan: 2, fontSize:9, alignment: 'center', bold: true },
                                '',
                                { text: 'Specs.', fontSize:9, alignment: 'center', bold: true },
                                { text: 'Process', fontSize:9, alignment: 'center', bold: true },
                                { text: `Q'ty`, fontSize:9, alignment: 'center', bold: true },
                                { text: 'Approve', fontSize:9, alignment: 'center', bold: true },
                                { text: 'Delivery', fontSize:9, alignment: 'center', bold: true },
                                { text: 'Encode', fontSize:9, alignment: 'center', bold: true }
                            ],
                            [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', '', '', ''],
                            [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', '', '', ''],
                            [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', '', '', ''],
                            [{ text: ' ', colSpan: 2 }, '', { text: '', colSpan: 2 }, '', '', { text: '', fontSize: 9, colSpan: 2 }, '', '', '', '', { text: 'A/SV-M', fontSize: 9, alignment: 'center' }, { text: 'Planner', fontSize: 9, alignment: 'center' }, { text: 'Staff', fontSize: 9, alignment: 'center' }],
                        ]
                    }
                }

            ],
            styles: {
                paddedCell: {
                    paddingLeft: 10,
                    paddingRight: 10,
                    paddingTop: 20,
                    paddingBottom: 20
                },
                tallCell: {
                    height: 50
                },

            }
        }
        const pdfDocGenerator = pdfMake.createPdf(qr_pdf1);
        pdfDocGenerator.getBlob((blobs) => {
            var timelapse = new Date().getTime();
            // URL.revokeObjectURL(pdfUrl)
            var pdfUrl = URL.createObjectURL(blobs);
            PDFObject.embed(pdfUrl, '#qr_embed', { height: '500px', width: '1000px', forcePDFJS: true });
        })
    }




    $HTML_PDF(data) {

    }


}

const qrclass = new QRCODE_PLAN()
export default qrclass