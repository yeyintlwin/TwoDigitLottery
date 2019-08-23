package com.yeyintlwin.twodigitlottery

/*
* Developer-Ye Yint Lwin
* 23 Aug 2019
*
* */
import android.annotation.SuppressLint
import android.os.Bundle
import android.support.v7.app.AppCompatActivity
import com.android.volley.Request
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import kotlinx.android.synthetic.main.activity_main.*
import org.json.JSONObject

class MainActivity : AppCompatActivity() {


    @SuppressLint("SetTextI18n")
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)
        loadData()
        button.setOnClickListener {
            textView.text = "loading..."
            loadData()
        }

    }

    @SuppressLint("SetTextI18n")
    private fun loadData() {

        val requestQueue = Volley.newRequestQueue(this)
        val stringRequest = StringRequest(
                Request.Method.POST,
                "https://yeyintlwinyz.000webhostapp.com/index_dom.php",
                Response.Listener {
                    val jsonObject = JSONObject(it)
                    textView.text = "Date: ${jsonObject.getString("date")}\nStatus: ${jsonObject.getString("status")}\nSet: ${jsonObject.getString("set")}\nVal: ${jsonObject.getString("val")}"
                    val set = jsonObject.getString("set")
                    val mal = jsonObject.getString("val")
                    val output = "${set.substring(set.length - 1)}${mal.substring(mal.lastIndexOf(".") - 1, mal.lastIndexOf("."))}"
                    textView.text = "${textView.text} \nOutput: $output"
                },
                Response.ErrorListener {
                    textView.text = it.toString()
                }
        )

        requestQueue.add(stringRequest)
        requestQueue.start()

    }
}
