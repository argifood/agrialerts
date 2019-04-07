import { Component, ViewChild, ElementRef, Input, AfterViewInit, ViewEncapsulation } from '@angular/core';
import { jqxGridComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxgrid';
import { jqxInputComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxinput';
import { jqxPanelComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxpanel';
import { StorageService } from '../storage.service';
import { ObService } from '../ob.service';

import { AuthService } from '../auth/auth.service';
import { AlertService } from '../alert.service';

declare var $: any;
@Component({
    selector: 'app-table',
    templateUrl: './table.component.html',
    styleUrls: ['./table.component.css'],
    encapsulation: ViewEncapsulation.None
})

export class TableComponent{
    @ViewChild('myGrid') myGrid: jqxGridComponent;
    @ViewChild('myInput') myInput: jqxInputComponent;
    @ViewChild('myPanel') myPanel: jqxPanelComponent;

    columns: any;
    source: any;
    columnsobs: any;
    sourceobs: any;
    dataAdapter: any;
    dataAdapterobs: any;
    tools: any;
    theme: any;
    initTools: any;
    mykey1: any;
    myareas: any;
    mycrops: any;
    area: any;
    kal_name: any;
    datefrom: any;
    dateto: any;
    myalerts: any;
    myobs: any;
    state: any = null;
    constructor(
        private getalertsService: AlertService,
        private getobsService: ObService,
        public authService: AuthService,
        private storageService: StorageService
    ) {};

    ngOnInit() {
        this.getalertsService.getPrivate().subscribe((result)=>{
            this.myalerts=result;
            console.log(this.myalerts);
            this.getobsService.getObs().subscribe((resultobs)=>{
                this.myobs=resultobs;
                console.log(this.myobs);
                this.columns = [
                    {text: 'Τίτλος', datafield: 'alert_name', pinned: true, width: '25%'},
                    {text: 'Κατηγορία', datafield: 'alerttype_name', pinned: true, width: '10%'},
                    {text: 'Καλλιέργεια', datafield: 'agritype_name', pinned: true, width: '10%'},
                    {text: 'Υπεβλήθη από', datafield: 'agency_name', pinned: true, width: '10%'},
                    {text: 'Περιοχή', datafield: 'kal_name', width: '25%'},
                    {text: 'Σοβαρότητα', datafield: 'agri_dim_severity', width: '10%'},
                    {text: 'Ημερ. Έναρξης', datafield: 'alert_from', width: '10%'},
                    {text: 'Ημερ. Λήξης', datafield: 'alert_to', width: '10%'}
                ];
                this.source = {
                    datatype: 'json',
                    datafields: [
                        {name: 'alerttype_name', type: 'string'},
                        {name: 'agritype_name', type: 'string'},
                        {name: 'agency_name', type: 'string'},
                        {name: 'kal_name', type: 'string'},
                        {name: 'alert_from', type: 'string'},
                        {name: 'alert_to', type: 'string'},
                        {name: 'alert_name', type: 'string'},
                        {name: 'agri_dim_severity', type: 'string'}
                    ],
                    localdata: this.myalerts
                };
                this.dataAdapter = new jqx.dataAdapter(this.source);
                this.columnsobs = [
                    {text: 'Τίτλος', datafield: 'observation_name', pinned: true, width: '25%'},
                    {text: 'Κατηγορία', datafield: 'alerttype_name', pinned: true, width: '10%'},
                    {text: 'Καλλιέργεια', datafield: 'agritype_name', pinned: true, width: '10%'},
                    {text: 'Υπεβλήθη από', datafield: 'agency_name', pinned: true, width: '10%'},
                    {text: 'Περιοχή', datafield: 'kal_name', width: '25%'},
                    {text: 'Σοβαρότητα', datafield: 'agri_dim_severity', width: '10%'},
                    {text: 'Ημερομηνία', datafield: 'observation_date', width: '10%'}
                ];
                this.sourceobs = {
                    datatype: 'json',
                    datafields: [
                        {name: 'alerttype_name', type: 'string'},
                        {name: 'agritype_name', type: 'string'},
                        {name: 'agency_name', type: 'string'},
                        {name: 'kal_name', type: 'string'},
                        {name: 'observation_date', type: 'string'},
                        {name: 'observation_name', type: 'string'},
                        {name: 'agri_dim_severity', type: 'string'}
                    ],
                    localdata: this.myobs
                };
                this.dataAdapterobs = new jqx.dataAdapter(this.sourceobs);
                this.tools = 'button button button button button button button | button | button | button';
                this.theme = 'darkblue';
                this.initTools = (type: string, index: number, tool: any, menuToolIninitialization: any): void => {
                    let icon = document.createElement('div');
                    if (type == 'button') {
                        icon.className = 'jqx-editor-toolbar-icon jqx-editor-toolbar-icon-' + this.theme + ' buttonIcon ';
                    }
                    switch (index) {
                        case 0:
                            tool[0].innerText = 'Excel';
                            tool.on('click', () => {
                                this.myGrid.exportdata('xls', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 1:
                            tool[0].innerText = 'CSV';
                            tool.on('click', () => {
                                this.myGrid.exportdata('csv', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 2:
                            tool[0].innerText = 'JSON';
                            tool.on('click', () => {
                                this.myGrid.exportdata('json', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 3:
                            tool[0].innerText = 'HTML';
                            tool.on('click', () => {
                                this.myGrid.exportdata('html', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 4:
                            tool[0].innerText = 'XML';
                            tool.on('click', () => {
                                this.myGrid.exportdata('xml', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 5:
                            tool[0].innerText = 'TSV';
                            tool.on('click', () => {
                                this.myGrid.exportdata('tsv', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 6:
                            tool[0].innerText = 'PDF';
                            tool.on('click', () => {
                                this.myGrid.exportdata('pdf', 'jqxGrid', true, null, true, 'https://jqwidgets.com/export_server/dataexport.php');
                            });
                            break;
                        case 7:
                            tool[0].innerText = 'Εκτύπωση πίνακα';
                            tool.on('click', () => {
                                let gridContent = this.myGrid.exportdata('html');
                                let newWindow = window.open('', '', 'width=800, height=500'),
                                    document = newWindow.document.open(),
                                    pageContent =
                                        '<!DOCTYPE html>\n' +
                                        '<html>\n' +
                                        '<head>\n' +
                                        '<meta charset="utf-8" />\n' +
                                        '<title>jQWidgets Grid</title>\n' +
                                        '</head>\n' +
                                        '<body>\n' + gridContent + '\n</body>\n</html>';
                                document.write(pageContent);
                                document.close();
                                newWindow.print();
                            });
                            break;
                        case 8:
                            tool[0].innerText = 'Αποθήκευση πίνακα';
                            tool.on('click', () => {
                                this.state = this.myGrid.savestate();
                            });
                            break;
                        case 9:
                            tool[0].innerText = 'Άνοιγμα αποθηκευμένου πίνακα';
                            tool.on('click', () => {
                                if (this.state) {
                                    this.myGrid.loadstate(this.state);
                                }
                                else {
                                    this.myGrid.loadstate({});
                                }
                            });
                            break;
                    }
                }
            });
        });
    }
}