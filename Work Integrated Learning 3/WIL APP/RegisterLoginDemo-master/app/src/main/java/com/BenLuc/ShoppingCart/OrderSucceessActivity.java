package com.BenLuc.ShoppingCart;

import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

import com.BenLuc.ShoppingCart.model.ShopCartModel;

public class OrderSucceessActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_succeess);


        ShopCartModel shopCartModel = getIntent().getParcelableExtra("ShopCartModel");
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle(shopCartModel.getName());
        actionBar.setSubtitle(shopCartModel.getAddress());
        actionBar.setDisplayHomeAsUpEnabled(false);


        TextView buttonDone = findViewById(R.id.buttonDone);
        buttonDone.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }
}