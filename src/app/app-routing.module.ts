import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { CallbackComponent } from './callback.component';
import { MapComponent } from './map/map.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { PublicComponent } from './public/public.component';
import { PrefsComponent } from './prefs/prefs.component';
import { PrefsAddComponent } from './prefs-add/prefs-add.component';
import { PrefsEditComponent } from './prefs-edit/prefs-edit.component';
import { ObsAddComponent } from './obs-add/obs-add.component';
import { AuthGuard } from './auth/auth.guard';

const routes: Routes = [
  { path: '', 
    component: PublicComponent
  },
	{ path: 'private', 
    component: SidebarComponent,
		canActivate: [
      AuthGuard
    ]
	},
  {
    path: 'prefs',
    component: PrefsComponent,
    canActivate: [
      AuthGuard
    ]
  },
  {
    path: 'prefs/add',
    component: PrefsAddComponent,
    canActivate: [
      AuthGuard
    ]
  },
  {
    path: 'prefs/edit/:id',
    component: PrefsEditComponent,
    canActivate: [
      AuthGuard
    ]
  },
  {
    path: 'obs/add',
    component: ObsAddComponent,
    canActivate: [
      AuthGuard
    ]
  },
  {
    path: 'callback',
    component: CallbackComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  providers: [AuthGuard],
  exports: [RouterModule]
})
export class AppRoutingModule { }