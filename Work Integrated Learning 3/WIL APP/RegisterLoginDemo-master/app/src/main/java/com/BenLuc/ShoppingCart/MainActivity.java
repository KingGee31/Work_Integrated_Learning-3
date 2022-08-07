package com.BenLuc.ShoppingCart;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

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

public class MainActivity extends AppCompatActivity {

    private EditText etEmail, etPassword;
    private String email, password;
    private Button loginBtn;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        email = password = "";
        etEmail = findViewById(R.id.etEmail);
        etPassword = findViewById(R.id.etPassword);
        loginBtn = findViewById(R.id.loginBtn);


        loginBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                //retrieving the values from the text-fields when the user clicks the register button
                email = etEmail.getEditableText().toString();
                password = etPassword.getEditableText().toString();

                //checking if the text-fields are not empty
                if(!email.equals("") && !password.equals("")){

                    if(!validateLoginPassword() | !validateLoginEmail()){
                        return;
                    }
                    else {

                        //Start ProgressBar first (Set visibility VISIBLE)
                        Handler handler = new Handler();
                        handler.post(new Runnable() {
                            @Override
                            public void run() {
                                //Starting Write and Read data with URL
                                //Creating array for parameters
                                String[] field = new String[2];
                                field[0] = "email";
                                field[1] = "password";
                                //Creating array for data
                                String[] data = new String[2];
                                data[0] = email;
                                data[1] = password;

                                PutData putData = new PutData("http://192.168.43.155/MyProjects/BenLucSystemWebsitedb/login.php", "POST", field, data);
                                if (putData.startPut()) {
                                    if (putData.onComplete()) {
                                        String result = putData.getResult();
                                        if(result.equals("Login Success") ){
                                            Toast.makeText(getApplicationContext(),result,Toast.LENGTH_SHORT).show();

                                            Intent intent2 = new Intent(MainActivity.this, Success.class);
                                            startActivity(intent2);
                                            finish();

                                        }else{
                                            Toast.makeText(getApplicationContext(),result,Toast.LENGTH_SHORT).show();
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

    //Validating fields in the login page
    private Boolean validateLoginPassword(){
        //Validating fields in the register class
        String val = etPassword.getEditableText().toString();
        String passwordPattern = "(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{8,}";

        if(val.isEmpty()){
            etPassword.setError("Field Cannot Be Empty");
            return false;
        }else if(!val.matches(passwordPattern)){
            etPassword.setError("Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters");
            return false;
        }
        else{
            etPassword.setError(null);
            return true;
        }
    }

    private Boolean validateLoginEmail(){
        //Validating fields in the register class
        String val = etEmail.getEditableText().toString();
        String emailPattern = "[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$";

        if(val.isEmpty()){
            etEmail.setError("Field Cannot Be Empty");
            return false;
        }else if(!val.matches(emailPattern)){
            etEmail.setError("Email Address must contain letters(lowercase only), maybe numbers in the format: characters@characters.domain");
            return false;
        }
        else{
            etEmail.setError(null);
            return true;
        }
    }


    public void register(View view) {
        Intent intent = new Intent(this, Register.class);
        startActivity(intent);
        finish();

    }
}