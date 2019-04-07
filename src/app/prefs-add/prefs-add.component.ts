import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormControl, FormGroup,  FormBuilder, FormArray, Validators } from '@angular/forms';
import { Subscription } from 'rxjs';
import { Pref } from '../pref';
import { Agritype } from '../agritype';
import { Nuts2 } from '../nuts2';
import { Nuts3 } from '../nuts3';
import { Nuts5 } from '../nuts5';
import { AuthService } from '../auth/auth.service';
import { PrefsService } from '../prefs.service';
import { ParamsService } from '../params.service';

@Component({
  selector: 'app-prefs-add',
  templateUrl: './prefs-add.component.html',
  styleUrls: ['./prefs-add.component.css']
})
export class PrefsAddComponent implements OnInit {
  agritypeSub: Subscription;
  nuts2Sub: Subscription;
  nuts3Sub: Subscription;
  nuts5Sub: Subscription;
  prefSub: Subscription;
  agritypes: Agritype[];
	nuts2s: Nuts2[];
	nuts3s: Nuts3[];
	nuts5s: Nuts5[];
  error: any;
	
	addPrefForm = this.fb.group({
		agritype_id:  ['', Validators.required],
		nuts2_id:  ['', Validators.required],
		nuts3_id:  [''],
		nuts5_id:  [''],
	});
	
	nuts2Change(event: any){
		let n2 = event.target.value;
		this.nuts3Sub = this.paramsService
		.getNuts3(n2)
		.subscribe(
			nuts3s => this.nuts3s = nuts3s,
			err => this.error = err
		);
		
	}
	
	nuts3Change(event: any){
		let n3 = event.target.value;
		this.nuts5Sub = this.paramsService
		.getNuts5(n3)
		.subscribe(
			nuts5s => this.nuts5s = nuts5s,
			err => this.error = err
		);
		
	}
	
	onSubmit(pref: Pref){
		pref.user_ext_id = this.authService.userID;
		this.prefSub = this.prefsService.addPref(JSON.stringify(pref)).subscribe();
	}
	
  constructor(
		private fb: FormBuilder,
		public prefsService: PrefsService,
		public paramsService: ParamsService,
		public authService: AuthService
		
	) { }

  ngOnInit() {
    this.agritypeSub = this.paramsService
      .getAgritypes()
      .subscribe(
        agritypes => this.agritypes = agritypes,
        err => this.error = err
      );

			this.nuts2Sub = this.paramsService
      .getNuts2()
      .subscribe(
        nuts2s => this.nuts2s = nuts2s,
        err => this.error = err
      );
  }

  ngOnDestroy() {
    this.agritypeSub.unsubscribe();
    this.nuts2Sub.unsubscribe();
  }
}
