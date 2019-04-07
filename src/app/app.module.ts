import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { MatTableModule } from  '@angular/material';
import { AppRoutingModule } from './app-routing.module';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ReactiveFormsModule } from '@angular/forms';
import { AppComponent } from './app.component';
import { MapComponent } from './map/map.component';

import { CallbackComponent } from './callback.component';
import { PublicComponent } from './public/public.component';
import { PrefsComponent } from './prefs/prefs.component';
import { PrefsAddComponent } from './prefs-add/prefs-add.component';
import { PrefsEditComponent } from './prefs-edit/prefs-edit.component';
import { AlertService } from './alert.service';
import { PrefsService } from './prefs.service';
import { ParamsService } from './params.service';
import { ObService } from './ob.service';
import { AuthService } from './auth/auth.service';

import { SettingsComponent } from './settings/settings.component';
import { HttpClientModule } from '@angular/common/http';
import { SidebarModule } from 'ng-sidebar';
import { TableComponent } from './table/table.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { jqxButtonComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxbuttons';
import { jqxGridComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxgrid';
import { jqxInputComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxinput';
import { jqxPanelComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxpanel';
import { jqxCheckBoxComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxcheckbox';
import { jqxDropDownButtonComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdropdownbutton';
import { jqxRadioButtonComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxradiobutton';
import { jqxSwitchButtonComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxswitchbutton';
import { jqxComboBoxComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxcombobox';
import { jqxDateTimeInputComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdatetimeinput';
import { jqxDropDownListComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxdropdownlist';
import { jqxWindowComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxwindow';
import { jqxToolBarComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxtoolbar';
import { jqxTabsComponent } from 'jqwidgets-scripts/jqwidgets-ts/angular_jqxtabs';
import { environment } from '../environments/environment';
//import { ObsComponent } from './obs/obs.component';
import { ObsAddComponent } from './obs-add/obs-add.component';
import { ShareButtonsModule } from '@ngx-share/buttons';

@NgModule({
  declarations: [
    AppComponent,MapComponent,SettingsComponent,TableComponent, SidebarComponent, PublicComponent, PrefsComponent,PrefsAddComponent,PrefsEditComponent,CallbackComponent,
    jqxButtonComponent, jqxCheckBoxComponent, jqxGridComponent, jqxPanelComponent, jqxInputComponent, jqxCheckBoxComponent,jqxTabsComponent,
    jqxDropDownButtonComponent, jqxRadioButtonComponent, jqxSwitchButtonComponent, jqxComboBoxComponent, jqxDateTimeInputComponent, jqxDropDownListComponent, jqxWindowComponent, jqxToolBarComponent, ObsAddComponent
  ],
  imports: [
    BrowserModule,AppRoutingModule,HttpClientModule,MatTableModule,CommonModule, FormsModule, SidebarModule.forRoot(),ReactiveFormsModule,ShareButtonsModule
  ],
  providers: [
    AlertService,
    ObService,
    PrefsService,
    ParamsService,
    AuthService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
