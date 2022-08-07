package com.BenLuc.ShoppingCart;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;

import com.BenLuc.ShoppingCart.adapter.ShopListAdapter;
import com.BenLuc.ShoppingCart.model.ShopCartModel;
import com.google.gson.Gson;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.StringWriter;
import java.io.Writer;
import java.util.Arrays;
import java.util.List;

public class MainActivity3 extends AppCompatActivity implements ShopListAdapter.ShopListClickListener {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main3);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Shop List");
        List<ShopCartModel> shopCartModelList = getShopCartData();

        initRecyclerView(shopCartModelList);
    }
    private void initRecyclerView( List<ShopCartModel> shopCartModelList){
        RecyclerView recyclerView = findViewById(R.id.recyclerView);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        ShopListAdapter adapter = new ShopListAdapter( shopCartModelList, this);

        recyclerView.setAdapter(adapter);

    }

    private List<ShopCartModel> getShopCartData() {
        InputStream is = getResources().openRawResource(R.raw.shop);
        Writer writer = new StringWriter();
        char[] buffer = new char[1024];
        try{
            Reader reader = new BufferedReader(new InputStreamReader(is, "UTF-8"));
            int n;
            while(( n = reader.read(buffer)) != -1) {
                writer.write(buffer, 0,n);
            }
        }catch (Exception e) {

        }

        String jsonStr = writer.toString();
        Gson gson = new Gson();
        ShopCartModel[] shopModels =  gson.fromJson(jsonStr, ShopCartModel[].class);
        List<ShopCartModel> shopList = Arrays.asList(shopModels);

        return  shopList;

    }


    @Override
    public void onItemClick(ShopCartModel shopCartModel) {
        Intent intent = new Intent(MainActivity3.this, ShopMenuActivity.class);
        intent.putExtra("ShopCartModel", shopCartModel);
        startActivity(intent);

    }
}
