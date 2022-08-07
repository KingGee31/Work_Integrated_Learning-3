package com.BenLuc.ShoppingCart;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.vishnusivadas.advanced_httpurlconnection.PutData;

import java.util.HashMap;
import java.util.Map;

public class Register extends AppCompatActivity {
    private EditText etName,etSurname, etEmail, etPassword, etReenterPassword;
    private TextView tvStatus;
    private Button btnRegister;
    private String name,surname, email, password, reenterPassword;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register);
        etName = findViewById(R.id.etName);
        etSurname = findViewById(R.id.etSurname);
        etEmail = findViewById(R.id.etEmail);
        etPassword = findViewById(R.id.etPassword);
        etReenterPassword = findViewById(R.id.etReenterPassword);
        tvStatus = findViewById(R.id.tvStatus);
        btnRegister = findViewById(R.id.btnRegister);
        name = surname = email = password = reenterPassword = "";



        btnRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                //retrieving the values from the textfields when the user clicks the register button
               name = etName.getEditableText().toString();
               surname = etSurname.getEditableText().toString();
                email = etEmail.getEditableText().toString();
                password = etPassword.getEditableText().toString();
                reenterPassword = etReenterPassword.getEditableText().toString();

                //checking if the fields have values
                if(!name.equals(" ") && !email.equals(" ") && !password.equals(" ") && !reenterPassword.equals(" ") && !surname.equals("")){

                    if(!validateName() | !validateEmail() | !validatePassword() | !validateConfirmPassword()){
                        return;
                    }
                    else{

                        //Start ProgressBar first (Set visibility VISIBLE)
                        Handler handler = new Handler();
                        handler.post(new Runnable() {
                            @Override
                            public void run() {
                                //Starting Write and Read data with URL
                                //Creating array for parameters
                                String[] field = new String[4];
                                field[0] = "name";
                                field[1] = "surname";
                                field[2] = "email";
                                field[3] = "password";
                                //Creating array for data
                                String[] data = new String[4];
                                data[0] = name;
                                data[1] = surname;
                                data[2] = email;
                                data[3] = password;
                                PutData putData = new PutData("http://192.168.43.155/MyProjects/BenLucSystemWebsitedb/signup.php", "POST", field, data);
                                if (putData.startPut()) {
                                    if (putData.onComplete()) {
                                        String result = putData.getResult();
                                        if(result.equals("Sign Up Success") ){
                                            Toast.makeText(getApplicationContext(),result,Toast.LENGTH_SHORT).show();

                                            Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                                            startActivity(intent);
                                            finish();

                                        }else{
                                            Toast.makeText(getApplicationContext(),result+"\nemail already registered, use different email-address",Toast.LENGTH_LONG).show();
                                        }

                                    }
                                }
                                //End Write and Read data with URL
                            }
                        });

                    }


                }else{
                    Toast.makeText(getApplicationContext(),"All fields are required",Toast.LENGTH_SHORT).show();
                }



            }
        });

    }

    //validating the text-fields before the values are saved to the database
    private boolean validateConfirmPassword(){
        //Validating fields in the register class
        String tempConfirmPassword = etReenterPassword.getEditableText().toString();
        String tempPassword = etPassword.getEditableText().toString();
        String passwordPattern = "(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}";

        if(tempConfirmPassword.isEmpty()){
            etReenterPassword.setError("Field Cannot Be Empty");
            return false;
        }
        else if(!tempConfirmPassword.matches(passwordPattern)){
            etReenterPassword.setError("Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters");
            return false;
        }
        else if(!tempConfirmPassword.matches(tempPassword)){
            etReenterPassword.setError("The 2 Passwords Do Not Match, Enter Matching Passwords");
            return false;
        }
        else{
            etReenterPassword.setError(null);
            return true;
        }
    }

    private Boolean validatePassword(){
        //Validating fields in the register class
        String tempPassword= etPassword.getEditableText().toString();
        String passwordPattern = "(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}";

        if(tempPassword.isEmpty()){
            etPassword.setError("Field Cannot Be Empty");
            return false;
        }else if(!tempPassword.matches(passwordPattern)){
            etPassword.setError("Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters");
            return false;
        }
        else{
            etPassword.setError(null);
            return true;
        }
    }

    private Boolean validateEmail(){
        //Validating fields in the register class
        String userName = etEmail.getEditableText().toString();
        String emailPattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$";

        if(userName.isEmpty()){
            etEmail.setError("Field Cannot Be Empty");
            return false;
        }else if(!userName.matches(emailPattern)){
            etEmail.setError("Email Address must contain letters(lowercase only), maybe numbers in the format: characters@characters.domain");
            return false;
        }
        else{
            etEmail.setError(null);
            return true;
        }
    }

    private Boolean validateName(){
        //Validating fields in the register class
        String fName = etName.getEditableText().toString();
        String sName = etSurname.getEditableText().toString();

        if(fName.isEmpty() | sName.isEmpty()){
            etName.setError("Field Cannot Be Empty");
            etSurname.setError("Field Cannot Be Empty");

            return false;
        }
        else{
            etName.setError(null);
            etSurname.setError(null);
            return true;
        }

    }


    public void login(View view) {
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
        finish();
    }
}
