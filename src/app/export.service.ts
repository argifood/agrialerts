import { Injectable, EventEmitter } from '@angular/core';    
import { Subscription } from 'rxjs/internal/Subscription';    
    
@Injectable({    
  providedIn: 'root'    
})    
export class ExportService {    
    
  invokeExportFunction = new EventEmitter();    
  subsVar: Subscription;    
    
  constructor() { }    
    
  onExportButtonClick() {    
    this.invokeExportFunction.emit(exportFiletype);    
  }    
}  