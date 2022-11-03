import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { StudentsService } from '../students.service';
@Component({
  selector: 'app-add-students',
  templateUrl: './add-students.component.html',
  styleUrls: ['./add-students.component.css']
})
export class AddStudentsComponent implements OnInit {
  addForm:any;

  HobbyList: any = ["Cricket","Movies","TV","Reading","Magazine"];
  HobbyArray: any[] = [];
  vals = '';
  data = this.vals.split(',');
  constructor( 
    private formBuilder: FormBuilder,
    private router: Router,
    private studentService: StudentsService  
  ) { 

    this.addForm = this.formBuilder.group({
      firstName: ['', Validators.required],
      lastName: ['', [Validators.required, Validators.maxLength(20)]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.maxLength(8), Validators.minLength(6)]],
      gender: ['', Validators.required],
      hobbyField: new FormControl(this.data),
      country: ['', Validators.required],
    })
  }

  get authorizedArray(){
    return this.addForm.get("hobbyField") as FormArray;
  }
  setAuthorized(data: string[]){
    this.HobbyArray = this.HobbyList.map((x:any) => ({
      name: x,
      value: data.indexOf(x) >= 0
    })
    )
  }

  parse(){
    const result = this.HobbyList.map(
      (x:any, index:any) => (this.HobbyArray[index].value ? x : null)
    ).filter((x:any) => x); 
    return result.length>0?result:null;
  }

  ngOnInit(): void {
    this.setAuthorized(this.data);
  }
  onSubmit(){
    console.log(this.addForm.value);
    this.studentService.createStudent(this.addForm.value).subscribe(
      (data:any) => {
        if(data.status=='success')
        {
          alert(data.message);
          this.router.navigate(['/']);
        }else if(data.status=='validationError')
        {
          alert(data.message);
        }
        else{
          alert(data.message);
        }
        
     
      }
    );
  }
}
