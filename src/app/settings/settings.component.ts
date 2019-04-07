import { Component, ElementRef, Input, AfterViewInit, ViewChild} from '@angular/core';
import { jqxDateTimeInputComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdatetimeinput';
import { jqxDropDownListComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdropdownlist';
import { jqxGridComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxgrid';

@Component({
  selector: 'app-settings',
  templateUrl: './settings.component.html'
})

export class SettingsComponent{
    @ViewChild('myDateTimeInput') myDateTimeInput; jqxDateTimeInputComponent;
    @ViewChild('myDropDownList1') myDropDownList1: jqxDropDownListComponent;
    @ViewChild('myDropDownList2') myDropDownList2: jqxDropDownListComponent;
    @ViewChild('myDropDownList3') myDropDownList3: jqxDropDownListComponent;
    @ViewChild('myGrid') myGrid: jqxGridComponent;
    @ViewChild('log') log: ElementRef; 
    @ViewChild('checkedItemsLog') checkedItemsLog: ElementRef;

    exportFiletype: any;
    
    constructor() { }
    ngAfterViewInit(): void {
        let date1 = new Date();
        date1.setFullYear(2013, 7, 7);
        let date2 = new Date();
        date2.setFullYear(2013, 7, 15);
        setTimeout(_=> this.myDateTimeInput.setRange(date1, date2));
    }

    submitButtonClicked(): void {
        var url='http://46.101.117.105/filterdata/crops=';
        let items1 = this.myDropDownList1.getCheckedItems();
        let items2 = this.myDropDownList2.getCheckedItems();
        for (let i = 0; i < items1.length; i++) {
            url += items1[i].value + ',';
        };
        url = url.substring(0, url.length - 2);
        url = url + '&geographic=';
        for (let i = 0; i < items2.length; i++) {
            url += items2[i].value + ',';
        };
        url = url.substring(0, url.length - 2);
        url += '&dates=';
        let selection = this.myDateTimeInput.getRange();
        url += selection.from.toLocaleDateString();
        url += ',';
        url += selection.to.toLocaleDateString();
        console.log(url);
    }

    source1: any = {
        datatype: 'json',
        datafields: [
            { name: 'kalcode' },
            { name: 'lektiko' }
        ],
        id: 'id',
        url: '../assets/mylocal.txt'
    };
    dataAdapter1: any = new jqx.dataAdapter(this.source1);

    source2: any = {
        datatype: 'json',
        datafields: [
            { name: 'kalcode' },
            { name: 'lektiko' }
        ],
        id: 'id',
        url: '../assets/mylocal.txt'
    };
    dataAdapter2: any = new jqx.dataAdapter(this.source2);

    source3: string[] =
    [
        'Excel','CSV','JSON','HTML','TSV','XML'
    ];

    cropOnSelect(event: any): void {
        if (event.args) {
            let item = event.args.item;
            if (item) {
                let valueElement = document.createElement('div');
                valueElement.innerHTML = `Value: ${item.kalcode}`;

                let labelElement = document.createElement('div');
                labelElement.innerHTML = `Label: ${item.lektiko}`;

                let checkedElement = document.createElement('div');
                checkedElement.innerHTML = `Checked: ${item.checked}`;

                let selectionLog = this.log.nativeElement;
                selectionLog.innerHTML = '';
                selectionLog.appendChild(labelElement);
                selectionLog.appendChild(valueElement);
                selectionLog.appendChild(checkedElement);

                let items = this.myDropDownList1.getCheckedItems();
                let checkedItems = '';
                for (let i = 0; i < items.length; i++) {
                    checkedItems += items[i].label + ', ';
                };
            }
        }
    };
    areaOnSelect(event: any): void {
        if (event.args) {
            let item = event.args.item;
            if (item) {
                let valueElement = document.createElement('div');
                valueElement.innerHTML = `Value: ${item.kalcode}`;

                let labelElement = document.createElement('div');
                labelElement.innerHTML = `Label: ${item.lektiko}`;

                let checkedElement = document.createElement('div');
                checkedElement.innerHTML = `Checked: ${item.checked}`;

                let selectionLog = this.log.nativeElement;
                selectionLog.innerHTML = '';
                selectionLog.appendChild(labelElement);
                selectionLog.appendChild(valueElement);
                selectionLog.appendChild(checkedElement);

                let items = this.myDropDownList2.getCheckedItems();
                let checkedItems = '';
                for (let i = 0; i < items.length; i++) {
                    checkedItems += items[i].label + ', ';
                };
            }
        }
    };
}