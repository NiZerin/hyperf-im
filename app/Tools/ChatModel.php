<?php


namespace App\Tools;


use App\Model\LiveImChat;
use Hyperf\DbConnection\Db;

class ChatModel
{
    public static function getChatModel(int $roomId)
    {
        $chatModel = new LiveImChat();
        $chatModel->setTable("live_chat_$roomId");
        return $chatModel;
    }

    public static function makeChatModel(int $roomId)
    {
        $checkTable = "DROP TABLE IF EXISTS `live_chat_$roomId`;";
        DB::select($checkTable);
        $makeTable = "CREATE TABLE `live_chat_$roomId` (`id` int(11) NOT NULL AUTO_INCREMENT,`im_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '对应 im id',`to_im_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '接收消息用户',`to_type` int(5) NULL DEFAULT NULL COMMENT '接收消息的属性 0：点对点个人消息，1：群消息（高级群） 2 聊天室',`from_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发送者类型 admin member',`from_im_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '发送消息用户',`msg_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'msg id ',`msg_content` json NULL COMMENT '消息内容',`msg_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '消息类别',`msg_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '消息发送中心',`created_by` int(11) NOT NULL DEFAULT 0 COMMENT '创建者',`updated_by` int(11) NOT NULL DEFAULT 0 COMMENT '更新者',`created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '创建时间',`updated_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0) COMMENT '更新时间',`deleted_at` timestamp(0) NULL DEFAULT NULL COMMENT '删除时间',PRIMARY KEY (`id`) USING BTREE) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;";
        DB::select($makeTable);
    }
}