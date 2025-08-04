USE [BULKSMSPanel]
GO

/****** Object:  Table [dbo].[OnlinePaymentHistory]    Script Date: 22/3/2017 12:06:44 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[OnlinePaymentHistory](
	[ID] [bigint] IDENTITY(1,1) NOT NULL,
	[UserName] [varchar](200) NULL,
	[TransactionId] [varchar](50) NULL,
	[MobileNo] [varchar](25) NULL,
	[Amount] [float] NULL,
	[Response] [nvarchar](max) NULL,
	[Status] [varchar](20) NULL,
	[PaymentValStatus] [varchar](50) NULL,
	[TransValStatus] [varchar](50) NULL,
	[HashValStatus] [tinyint] NULL,
	[CreatedBy] [varchar](50) NULL,
	[DataEntryDate] [datetime] NULL,
 CONSTRAINT [PK__OnlinePa__3214EC27F36D98AA] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO


