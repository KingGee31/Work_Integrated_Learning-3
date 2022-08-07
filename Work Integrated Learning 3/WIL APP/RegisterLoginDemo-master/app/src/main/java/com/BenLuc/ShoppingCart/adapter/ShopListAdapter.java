package com.BenLuc.ShoppingCart.adapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.BenLuc.ShoppingCart.R;
import com.BenLuc.ShoppingCart.model.ShopCartModel;
import com.bumptech.glide.Glide;

import java.util.List;

public class ShopListAdapter extends RecyclerView.Adapter<ShopListAdapter.MyViewHolder> {
    private List<ShopCartModel> shopCartModelList;
    private ShopListClickListener clickListener;


    public ShopListAdapter(List<ShopCartModel> shopCartModelList, ShopListClickListener clickListener) {
        this.shopCartModelList = shopCartModelList;
        this.clickListener = clickListener;

    }

    public void updateData(List<ShopCartModel> shopCartModelList) {
        this.shopCartModelList = shopCartModelList;
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public ShopListAdapter.MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.recycler_row, parent, false);
        return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ShopListAdapter.MyViewHolder holder, int position) {
        holder.shopName.setText(shopCartModelList.get(position).getName());
        holder.shopAddress.setText("Address: " + shopCartModelList.get(position).getAddress());
        holder.shopHours.setText("Today's hours: " + shopCartModelList.get(position).getHours().getTodaysHours());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                clickListener.onItemClick(shopCartModelList.get(position));

            }
        });


        Glide.with(holder.thumbImage)
                .load(shopCartModelList.get(position).getImage())
                .into(holder.thumbImage);

    }


    @Override
    public int getItemCount() {
        return shopCartModelList.size();
    }

    static class MyViewHolder extends RecyclerView.ViewHolder {
        TextView shopName;
        TextView shopAddress;
        TextView shopHours;
        ImageView thumbImage;

        public MyViewHolder(View view) {
            super(view);
            shopName = view.findViewById(R.id.ShopName);
            shopAddress = view.findViewById(R.id.ShopAddress);
            shopHours = view.findViewById(R.id.ShopHours);
            thumbImage = view.findViewById(R.id.thumbImage);

        }

    }

    public interface ShopListClickListener {
        public void onItemClick(ShopCartModel shopCartModel);

    }
}